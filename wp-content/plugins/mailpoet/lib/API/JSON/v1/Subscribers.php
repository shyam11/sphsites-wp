<?php

namespace MailPoet\API\JSON\v1;

if (!defined('ABSPATH')) exit;


use MailPoet\API\JSON\Endpoint as APIEndpoint;
use MailPoet\API\JSON\Error as APIError;
use MailPoet\API\JSON\Response as APIResponse;
use MailPoet\API\JSON\ResponseBuilders\SubscribersResponseBuilder;
use MailPoet\Config\AccessControl;
use MailPoet\Doctrine\Validator\ValidationException;
use MailPoet\Entities\FormEntity;
use MailPoet\Entities\SegmentEntity;
use MailPoet\Entities\SubscriberEntity;
use MailPoet\Form\FormsRepository;
use MailPoet\Form\Util\FieldNameObfuscator;
use MailPoet\Listing;
use MailPoet\Models\Form;
use MailPoet\Models\StatisticsForms;
use MailPoet\Models\Subscriber;
use MailPoet\Segments\SegmentsRepository;
use MailPoet\Settings\SettingsController;
use MailPoet\Subscribers\ConfirmationEmailMailer;
use MailPoet\Subscribers\RequiredCustomFieldValidator;
use MailPoet\Subscribers\SubscriberActions;
use MailPoet\Subscribers\SubscriberListingRepository;
use MailPoet\Subscribers\SubscriberSaveController;
use MailPoet\Subscribers\SubscribersRepository;
use MailPoet\Subscription\Captcha;
use MailPoet\Subscription\CaptchaSession;
use MailPoet\Subscription\SubscriptionUrlFactory;
use MailPoet\Subscription\Throttling as SubscriptionThrottling;
use MailPoet\UnexpectedValueException;
use MailPoet\WP\Functions as WPFunctions;

class Subscribers extends APIEndpoint {
  const SUBSCRIPTION_LIMIT_COOLDOWN = 60;

  public $permissions = [
    'global' => AccessControl::PERMISSION_MANAGE_SUBSCRIBERS,
    'methods' => ['subscribe' => AccessControl::NO_ACCESS_RESTRICTION],
  ];

  /** @var SubscriberActions */
  private $subscriberActions;

  /** @var RequiredCustomFieldValidator */
  private $requiredCustomFieldValidator;

  /** @var Listing\Handler */
  private $listingHandler;

  /** @var Captcha */
  private $subscriptionCaptcha;

  /** @var SettingsController */
  private $settings;

  /** @var CaptchaSession */
  private $captchaSession;

  /** @var ConfirmationEmailMailer; */
  private $confirmationEmailMailer;

  /** @var SubscriptionUrlFactory */
  private $subscriptionUrlFactory;

  /** @var FieldNameObfuscator */
  private $fieldNameObfuscator;

  /** @var SubscribersRepository */
  private $subscribersRepository;

  /** @var SubscribersResponseBuilder */
  private $subscribersResponseBuilder;

  /** @var SubscriberListingRepository */
  private $subscriberListingRepository;

  /** @var SegmentsRepository */
  private $segmentsRepository;

  /** @var FormsRepository */
  private $formsRepository;

  /** @var SubscriberSaveController */
  private $saveController;

  public function __construct(
    SubscriberActions $subscriberActions,
    RequiredCustomFieldValidator $requiredCustomFieldValidator,
    Listing\Handler $listingHandler,
    Captcha $subscriptionCaptcha,
    SettingsController $settings,
    CaptchaSession $captchaSession,
    ConfirmationEmailMailer $confirmationEmailMailer,
    SubscriptionUrlFactory $subscriptionUrlFactory,
    SubscribersRepository $subscribersRepository,
    SubscribersResponseBuilder $subscribersResponseBuilder,
    SubscriberListingRepository $subscriberListingRepository,
    SegmentsRepository $segmentsRepository,
    FieldNameObfuscator $fieldNameObfuscator,
    FormsRepository $formsRepository,
    SubscriberSaveController $saveController
  ) {
    $this->subscriberActions = $subscriberActions;
    $this->requiredCustomFieldValidator = $requiredCustomFieldValidator;
    $this->listingHandler = $listingHandler;
    $this->subscriptionCaptcha = $subscriptionCaptcha;
    $this->settings = $settings;
    $this->captchaSession = $captchaSession;
    $this->confirmationEmailMailer = $confirmationEmailMailer;
    $this->subscriptionUrlFactory = $subscriptionUrlFactory;
    $this->fieldNameObfuscator = $fieldNameObfuscator;
    $this->subscribersRepository = $subscribersRepository;
    $this->subscribersResponseBuilder = $subscribersResponseBuilder;
    $this->subscriberListingRepository = $subscriberListingRepository;
    $this->segmentsRepository = $segmentsRepository;
    $this->formsRepository = $formsRepository;
    $this->saveController = $saveController;
  }

  public function get($data = []) {
    $subscriber = $this->getSubscriber($data);
    if (!$subscriber instanceof SubscriberEntity) {
      return $this->errorResponse([
        APIError::NOT_FOUND => WPFunctions::get()->__('This subscriber does not exist.', 'mailpoet'),
      ]);
    }
    $result = $this->subscribersResponseBuilder->build($subscriber);
    return $this->successResponse($result);
  }

  public function listing($data = []) {
    $definition = $this->listingHandler->getListingDefinition($data);
    $items = $this->subscriberListingRepository->getData($definition);
    $count = $this->subscriberListingRepository->getCount($definition);
    $filters = $this->subscriberListingRepository->getFilters($definition);
    $groups = $this->subscriberListingRepository->getGroups($definition);
    $subscribers = $this->subscribersResponseBuilder->buildForListing($items);
    if ($data['filter']['segment'] ?? false) {
      foreach ($subscribers as $key => $subscriber) {
        $subscribers[$key] = $this->preferUnsubscribedStatusFromSegment($subscriber, $data['filter']['segment']);
      }
    }
    return $this->successResponse($subscribers, [
      'count' => $count,
      'filters' => $filters,
      'groups' => $groups,
    ]);
  }

  private function preferUnsubscribedStatusFromSegment(array $subscriber, $segmentId) {
    $segmentStatus = $this->findSegmentStatus($subscriber, $segmentId);

    if ($segmentStatus === Subscriber::STATUS_UNSUBSCRIBED) {
      $subscriber['status'] = $segmentStatus;
    }
    return $subscriber;
  }

  private function findSegmentStatus(array $subscriber, $segmentId) {
    foreach ($subscriber['subscriptions'] as $segment) {
      if ($segment['segment_id'] === $segmentId) {
        return $segment['status'];
      }
    }
  }

  public function subscribe($data = []) {
    $formId = (isset($data['form_id']) ? (int)$data['form_id'] : false);
    $form = Form::findOne($formId);
    $formEntity = $this->formsRepository->findOneById($formId);
    unset($data['form_id']);

    if (!$form instanceof Form || !$formEntity instanceof FormEntity) {
      return $this->badRequest([
        APIError::BAD_REQUEST => WPFunctions::get()->__('Please specify a valid form ID.', 'mailpoet'),
      ]);
    }
    if (!empty($data['email'])) {
      return $this->badRequest([
        APIError::BAD_REQUEST => WPFunctions::get()->__('Please leave the first field empty.', 'mailpoet'),
      ]);
    }

    $captchaSettings = $this->settings->get('captcha');

    if (!empty($captchaSettings['type'])
      && $captchaSettings['type'] === Captcha::TYPE_BUILTIN
    ) {
      $captchaSessionId = isset($data['captcha_session_id']) ? $data['captcha_session_id'] : null;
      $this->captchaSession->init($captchaSessionId);
      if (!isset($data['captcha'])) {
        // Save form data to session
        $this->captchaSession->setFormData(array_merge($data, ['form_id' => $formId]));
      } elseif ($this->captchaSession->getFormData()) {
        // Restore form data from session
        $data = array_merge($this->captchaSession->getFormData(), ['captcha' => $data['captcha']]);
      }
      // Otherwise use the post data
    }

    $data = $this->deobfuscateFormPayload($data);

    try {
      $this->requiredCustomFieldValidator->validate($data, $form);
    } catch (\Exception $e) {
      return $this->badRequest([APIError::BAD_REQUEST => $e->getMessage()]);
    }

    $segmentIds = (!empty($data['segments'])
      ? (array)$data['segments']
      : []
    );
    $segmentIds = $this->getSegmentsForSubscription($formEntity, $segmentIds);
    unset($data['segments']);

    if (empty($segmentIds)) {
      return $this->badRequest([
        APIError::BAD_REQUEST => WPFunctions::get()->__('Please select a list.', 'mailpoet'),
      ]);
    }

    $captchaValidationResult = $this->validateCaptcha($captchaSettings, $data);
    if ($captchaValidationResult instanceof APIResponse) {
      return $captchaValidationResult;
    }

    // only accept fields defined in the form
    $formFields = $form->getFieldList();
    $data = array_intersect_key($data, array_flip($formFields));

    // make sure we don't allow too many subscriptions with the same ip address
    $timeout = SubscriptionThrottling::throttle();

    if ($timeout > 0) {
      $timeToWait = SubscriptionThrottling::secondsToTimeString($timeout);
      $meta = [];
      $meta['refresh_captcha'] = true;
      return $this->badRequest([
        APIError::BAD_REQUEST => sprintf(WPFunctions::get()->__('You need to wait %s before subscribing again.', 'mailpoet'), $timeToWait),
      ], $meta);
    }

    $subscriber = $this->subscriberActions->subscribe($data, $segmentIds);
    $errors = $subscriber->getErrors();

    if ($errors !== false) {
      return $this->badRequest($errors);
    } else {
      if (!empty($captchaSettings['type']) && $captchaSettings['type'] === Captcha::TYPE_BUILTIN) {
        // Captcha has been verified, invalidate the session vars
        $this->captchaSession->reset();
      }

      $meta = [];

      if ($form !== false) {
        // record form statistics
        StatisticsForms::record($form->id, $subscriber->id);

        $form = $form->asArray();

        if (!empty($form['settings']['on_success'])) {
          if ($form['settings']['on_success'] === 'page') {
            // redirect to a page on a success, pass the page url in the meta
            $meta['redirect_url'] = WPFunctions::get()->getPermalink($form['settings']['success_page']);
          } else if ($form['settings']['on_success'] === 'url') {
            $meta['redirect_url'] = $form['settings']['success_url'];
          }
        }
      }

      return $this->successResponse(
        [],
        $meta
      );
    }
  }

  private function deobfuscateFormPayload($data) {
    return $this->fieldNameObfuscator->deobfuscateFormPayload($data);
  }

  private function validateCaptcha($captchaSettings, $data) {
    if (empty($captchaSettings['type'])) {
      return true;
    }

    $isBuiltinCaptchaRequired = false;
    if ($captchaSettings['type'] === Captcha::TYPE_BUILTIN) {
      $isBuiltinCaptchaRequired = $this->subscriptionCaptcha->isRequired(isset($data['email']) ? $data['email'] : '');
      if ($isBuiltinCaptchaRequired && empty($data['captcha'])) {
        $meta = [];
        $meta['redirect_url'] = $this->subscriptionUrlFactory->getCaptchaUrl($this->captchaSession->getId());
        return $this->badRequest([
          APIError::BAD_REQUEST => WPFunctions::get()->__('Please fill in the CAPTCHA.', 'mailpoet'),
        ], $meta);
      }
    }

    if ($captchaSettings['type'] === Captcha::TYPE_RECAPTCHA && empty($data['recaptcha'])) {
      return $this->badRequest([
        APIError::BAD_REQUEST => WPFunctions::get()->__('Please check the CAPTCHA.', 'mailpoet'),
      ]);
    }

    if ($captchaSettings['type'] === Captcha::TYPE_RECAPTCHA) {
      $res = empty($data['recaptcha']) ? $data['recaptcha-no-js'] : $data['recaptcha'];
      $res = WPFunctions::get()->wpRemotePost('https://www.google.com/recaptcha/api/siteverify', [
        'body' => [
          'secret' => $captchaSettings['recaptcha_secret_token'],
          'response' => $res,
        ],
      ]);
      if (is_wp_error($res)) {
        return $this->badRequest([
          APIError::BAD_REQUEST => WPFunctions::get()->__('Error while validating the CAPTCHA.', 'mailpoet'),
        ]);
      }
      $res = json_decode(wp_remote_retrieve_body($res));
      if (empty($res->success)) {
        return $this->badRequest([
          APIError::BAD_REQUEST => WPFunctions::get()->__('Error while validating the CAPTCHA.', 'mailpoet'),
        ]);
      }
    } elseif ($captchaSettings['type'] === Captcha::TYPE_BUILTIN && $isBuiltinCaptchaRequired) {
      $captchaHash = $this->captchaSession->getCaptchaHash();
      if (empty($captchaHash)) {
        return $this->badRequest([
          APIError::BAD_REQUEST => WPFunctions::get()->__('Please regenerate the CAPTCHA.', 'mailpoet'),
        ]);
      } elseif (!hash_equals(strtolower($data['captcha']), strtolower($captchaHash))) {
        $this->captchaSession->setCaptchaHash(null);
        $meta = [];
        $meta['refresh_captcha'] = true;
        return $this->badRequest([
          APIError::BAD_REQUEST => WPFunctions::get()->__('The characters entered do not match with the previous CAPTCHA.', 'mailpoet'),
        ], $meta);
      }
    }

    return true;
  }

  public function save($data = []) {
    try {
      $subscriber = $this->saveController->save($data);
    } catch (ValidationException $validationException) {
      return $this->badRequest([$this->getErrorMessage($validationException)]);
    }

    return $this->successResponse(
      $this->subscribersResponseBuilder->build($subscriber)
    );
  }

  public function restore($data = []) {
    $subscriber = $this->getSubscriber($data);
    if ($subscriber instanceof SubscriberEntity) {
      $this->subscribersRepository->bulkRestore([$subscriber->getId()]);
      $this->subscribersRepository->refresh($subscriber);
      return $this->successResponse(
        $this->subscribersResponseBuilder->build($subscriber),
        ['count' => 1]
      );
    } else {
      return $this->errorResponse([
        APIError::NOT_FOUND => WPFunctions::get()->__('This subscriber does not exist.', 'mailpoet'),
      ]);
    }
  }

  public function trash($data = []) {
    $subscriber = $this->getSubscriber($data);
    if ($subscriber instanceof SubscriberEntity) {
      $this->subscribersRepository->bulkTrash([$subscriber->getId()]);
      $this->subscribersRepository->refresh($subscriber);
      return $this->successResponse(
        $this->subscribersResponseBuilder->build($subscriber),
        ['count' => 1]
      );
    } else {
      return $this->errorResponse([
        APIError::NOT_FOUND => WPFunctions::get()->__('This subscriber does not exist.', 'mailpoet'),
      ]);
    }
  }

  public function delete($data = []) {
    $subscriber = $this->getSubscriber($data);
    if ($subscriber instanceof SubscriberEntity) {
      $count = $this->subscribersRepository->bulkDelete([$subscriber->getId()]);
      return $this->successResponse(null, ['count' => $count]);
    } else {
      return $this->errorResponse([
        APIError::NOT_FOUND => WPFunctions::get()->__('This subscriber does not exist.', 'mailpoet'),
      ]);
    }
  }

  public function sendConfirmationEmail($data = []) {
    $id = (isset($data['id']) ? (int)$data['id'] : false);
    $subscriber = Subscriber::findOne($id);
    if ($subscriber instanceof Subscriber) {
      if ($this->confirmationEmailMailer->sendConfirmationEmail($subscriber)) {
        return $this->successResponse();
      }
      return $this->errorResponse();
    } else {
      return $this->errorResponse([
        APIError::NOT_FOUND => WPFunctions::get()->__('This subscriber does not exist.', 'mailpoet'),
      ]);
    }
  }

  public function bulkAction($data = []) {
    $definition = $this->listingHandler->getListingDefinition($data['listing']);
    $ids = $this->subscriberListingRepository->getActionableIds($definition);

    $count = 0;
    $segment = null;
    if (isset($data['segment_id'])) {
      $segment = $this->getSegment($data);
      if (!$segment) {
        return $this->errorResponse([
          APIError::NOT_FOUND => WPFunctions::get()->__('This segment does not exist.', 'mailpoet'),
        ]);
      }
    }

    if ($data['action'] === 'trash') {
      $count = $this->subscribersRepository->bulkTrash($ids);
    } elseif ($data['action'] === 'restore') {
      $count = $this->subscribersRepository->bulkRestore($ids);
    } elseif ($data['action'] === 'delete') {
      $count = $this->subscribersRepository->bulkDelete($ids);
    } elseif ($data['action'] === 'removeFromAllLists') {
      $count = $this->subscribersRepository->bulkRemoveFromAllSegments($ids);
    } elseif ($data['action'] === 'removeFromList' && $segment instanceof SegmentEntity) {
      $count = $this->subscribersRepository->bulkRemoveFromSegment($segment, $ids);
    } elseif ($data['action'] === 'addToList' && $segment instanceof SegmentEntity) {
      $count = $this->subscribersRepository->bulkAddToSegment($segment, $ids);
    } elseif ($data['action'] === 'moveToList' && $segment instanceof SegmentEntity) {
      $count = $this->subscribersRepository->bulkMoveToSegment($segment, $ids);
    } elseif ($data['action'] === 'unsubscribe') {
      $count = $this->subscribersRepository->bulkUnsubscribe($ids);
    } else {
      throw UnexpectedValueException::create()
        ->withErrors([APIError::BAD_REQUEST => "Invalid bulk action '{$data['action']}' provided."]);
    }
    $meta = [
      'count' => $count,
    ];

    if ($segment) {
      $meta['segment'] = $segment->getName();
    }
    return $this->successResponse(null, $meta);
  }

  /**
   * @param array $data
   * @return SubscriberEntity|null
   */
  private function getSubscriber($data) {
    return isset($data['id'])
      ? $this->subscribersRepository->findOneById((int)$data['id'])
      : null;
  }

  private function getSegment(array $data): ?SegmentEntity {
    return isset($data['segment_id'])
      ? $this->segmentsRepository->findOneById((int)$data['segment_id'])
      : null;
  }

  private function getSegmentsForSubscription(FormEntity $formEntity, array $submittedSegmentIds = []): array {
    // If form contains segment selection blocks allow only segments ids configured in those blocks
    $segmentBlocksSegmentIds = $formEntity->getSegmentBlocksSegmentIds();
    if (!empty($segmentBlocksSegmentIds)) {
      return array_intersect($submittedSegmentIds, $segmentBlocksSegmentIds);
    }
    return $formEntity->getSettingsSegmentIds();
  }

  private function getErrorMessage(ValidationException $exception): string {
    $exceptionMessage = $exception->getMessage();
    if (strpos($exceptionMessage, 'This value should not be blank.') !== false) {
      return WPFunctions::get()->__('Please enter your email address', 'mailpoet');
    } elseif (strpos($exceptionMessage, 'This value is not a valid email address.') !== false) {
      return WPFunctions::get()->__('Your email address is invalid!', 'mailpoet');
    }

    return WPFunctions::get()->__('Unexpected error.', 'mailpoet');
  }
}
