<?php
 namespace MailPoetVendor\Doctrine\Common\Collections; if (!defined('ABSPATH')) exit; use MailPoetVendor\Doctrine\Common\Collections\Expr\Expression; use MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression; class Criteria { const ASC = 'ASC'; const DESC = 'DESC'; private static $expressionBuilder; private $expression; private $orderings = []; private $firstResult; private $maxResults; public static function create() { return new static(); } public static function expr() { if (self::$expressionBuilder === null) { self::$expressionBuilder = new \MailPoetVendor\Doctrine\Common\Collections\ExpressionBuilder(); } return self::$expressionBuilder; } public function __construct(\MailPoetVendor\Doctrine\Common\Collections\Expr\Expression $expression = null, array $orderings = null, $firstResult = null, $maxResults = null) { $this->expression = $expression; $this->setFirstResult($firstResult); $this->setMaxResults($maxResults); if (null !== $orderings) { $this->orderBy($orderings); } } public function where(\MailPoetVendor\Doctrine\Common\Collections\Expr\Expression $expression) { $this->expression = $expression; return $this; } public function andWhere(\MailPoetVendor\Doctrine\Common\Collections\Expr\Expression $expression) { if ($this->expression === null) { return $this->where($expression); } $this->expression = new \MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression(\MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression::TYPE_AND, [$this->expression, $expression]); return $this; } public function orWhere(\MailPoetVendor\Doctrine\Common\Collections\Expr\Expression $expression) { if ($this->expression === null) { return $this->where($expression); } $this->expression = new \MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression(\MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression::TYPE_OR, [$this->expression, $expression]); return $this; } public function getWhereExpression() { return $this->expression; } public function getOrderings() { return $this->orderings; } public function orderBy(array $orderings) { $this->orderings = \array_map(function (string $ordering) : string { return \strtoupper($ordering) === \MailPoetVendor\Doctrine\Common\Collections\Criteria::ASC ? \MailPoetVendor\Doctrine\Common\Collections\Criteria::ASC : \MailPoetVendor\Doctrine\Common\Collections\Criteria::DESC; }, $orderings); return $this; } public function getFirstResult() { return $this->firstResult; } public function setFirstResult($firstResult) { $this->firstResult = null === $firstResult ? null : (int) $firstResult; return $this; } public function getMaxResults() { return $this->maxResults; } public function setMaxResults($maxResults) { $this->maxResults = null === $maxResults ? null : (int) $maxResults; return $this; } } 