<?php
 namespace MailPoetVendor\Doctrine\ORM\Query\AST; if (!defined('ABSPATH')) exit; class CollectionMemberExpression extends \MailPoetVendor\Doctrine\ORM\Query\AST\Node { public $entityExpression; public $collectionValuedPathExpression; public $not; public function __construct($entityExpr, $collValuedPathExpr) { $this->entityExpression = $entityExpr; $this->collectionValuedPathExpression = $collValuedPathExpr; } public function dispatch($walker) { return $walker->walkCollectionMemberExpression($this); } } 