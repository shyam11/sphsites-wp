<?php
 namespace MailPoetVendor\Doctrine\ORM\Mapping; if (!defined('ABSPATH')) exit; use MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform; class DefaultQuoteStrategy implements \MailPoetVendor\Doctrine\ORM\Mapping\QuoteStrategy { public function getColumnName($fieldName, \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $class, \MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform $platform) { return isset($class->fieldMappings[$fieldName]['quoted']) ? $platform->quoteIdentifier($class->fieldMappings[$fieldName]['columnName']) : $class->fieldMappings[$fieldName]['columnName']; } public function getTableName(\MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $class, \MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform $platform) { $tableName = $class->table['name']; if (!empty($class->table['schema'])) { $tableName = $class->table['schema'] . '.' . $class->table['name']; if (!$platform->supportsSchemas() && $platform->canEmulateSchemas()) { $tableName = $class->table['schema'] . '__' . $class->table['name']; } } return isset($class->table['quoted']) ? $platform->quoteIdentifier($tableName) : $tableName; } public function getSequenceName(array $definition, \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $class, \MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform $platform) { return isset($definition['quoted']) ? $platform->quoteIdentifier($definition['sequenceName']) : $definition['sequenceName']; } public function getJoinColumnName(array $joinColumn, \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $class, \MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform $platform) { return isset($joinColumn['quoted']) ? $platform->quoteIdentifier($joinColumn['name']) : $joinColumn['name']; } public function getReferencedJoinColumnName(array $joinColumn, \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $class, \MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform $platform) { return isset($joinColumn['quoted']) ? $platform->quoteIdentifier($joinColumn['referencedColumnName']) : $joinColumn['referencedColumnName']; } public function getJoinTableName(array $association, \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $class, \MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform $platform) { $schema = ''; if (isset($association['joinTable']['schema'])) { $schema = $association['joinTable']['schema']; $schema .= !$platform->supportsSchemas() && $platform->canEmulateSchemas() ? '__' : '.'; } $tableName = $association['joinTable']['name']; if (isset($association['joinTable']['quoted'])) { $tableName = $platform->quoteIdentifier($tableName); } return $schema . $tableName; } public function getIdentifierColumnNames(\MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $class, \MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform $platform) { $quotedColumnNames = []; foreach ($class->identifier as $fieldName) { if (isset($class->fieldMappings[$fieldName])) { $quotedColumnNames[] = $this->getColumnName($fieldName, $class, $platform); continue; } $joinColumns = $class->associationMappings[$fieldName]['joinColumns']; $assocQuotedColumnNames = \array_map(function ($joinColumn) use($platform) { return isset($joinColumn['quoted']) ? $platform->quoteIdentifier($joinColumn['name']) : $joinColumn['name']; }, $joinColumns); $quotedColumnNames = \array_merge($quotedColumnNames, $assocQuotedColumnNames); } return $quotedColumnNames; } public function getColumnAlias($columnName, $counter, \MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform $platform, \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $class = null) { $columnName = $columnName . '_' . $counter; $columnName = \substr($columnName, -$platform->getMaxIdentifierLength()); $columnName = \preg_replace('/[^A-Za-z0-9_]/', '', $columnName); $columnName = \is_numeric($columnName) ? '_' . $columnName : $columnName; return $platform->getSQLResultCasing($columnName); } } 