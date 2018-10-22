<?php

namespace srag\AVL\Plugins\MailLogger\Log;

use ActiveRecord;
use arConnector;
use ilMailLoggerPlugin;
use srag\AVL\Plugins\MailLogger\Utils\MailLoggerTrait;
use srag\DIC\DICTrait;

/**
 * Class Log
 *
 * @package srag\AVL\Plugins\MailLogger\Log
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Log extends ActiveRecord {

	use DICTrait;
	use MailLoggerTrait;
	const TABLE_NAME = "maillog_log";
	const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;


	/**
	 * @return string
	 */
	public function getConnectorContainerName(): string {
		return self::TABLE_NAME;
	}


	/**
	 * @return string
	 *
	 * @deprecated
	 */
	public static function returnDbTableName(): string {
		return self::TABLE_NAME;
	}


	/**
	 * @var int
	 *
	 * @con_has_field   true
	 * @con_fieldtype   integer
	 * @con_length      8
	 * @con_is_notnull  true
	 * @con_is_primary  true
	 * @con_sequence    true
	 */
	protected $id;
	/**
	 * @var string
	 *
	 * @con_has_field   true
	 * @con_fieldtype   text
	 * @con_is_notnull  true
	 */
	protected $subject = "";
	/**
	 * @var string
	 *
	 * @con_has_field   true
	 * @con_fieldtype   text
	 * @con_is_notnull  true
	 */
	protected $body = "";
	/**
	 * @var bool
	 *
	 * @con_has_field   true
	 * @con_fieldtype   integer
	 * @con_length      1
	 * @con_is_notnull  true
	 */
	protected $is_system = false;
	/**
	 * @var string
	 *
	 * @con_has_field   true
	 * @con_fieldtype   text
	 * @con_is_notnull  true
	 */
	protected $from_name = "";
	/**
	 * @var string
	 *
	 * @con_has_field   true
	 * @con_fieldtype   text
	 * @con_is_notnull  true
	 */
	protected $from_email = "";
	/**
	 * @var int
	 *
	 * @con_has_field   true
	 * @con_fieldtype   integer
	 * @con_length      8
	 * @con_is_notnull  true
	 */
	protected $from_user_id = - 1;
	/**
	 * @var string
	 *
	 * @con_has_field   true
	 * @con_fieldtype   text
	 * @con_is_notnull  true
	 */
	protected $to_name = "";
	/**
	 * @var string
	 *
	 * @con_has_field   true
	 * @con_fieldtype   text
	 * @con_is_notnull  true
	 */
	protected $to_email = "";
	/**
	 * @var int
	 *
	 * @con_has_field   true
	 * @con_fieldtype   integer
	 * @con_length      8
	 * @con_is_notnull  true
	 */
	protected $to_user_id = - 1;
	/**
	 * @var int
	 *
	 * @con_has_field   true
	 * @con_fieldtype   integer
	 * @con_length      8
	 * @con_is_notnull  true
	 */
	protected $context_ref_id = - 1;
	/**
	 * @var int
	 *
	 * @con_has_field   true
	 * @con_fieldtype   integer
	 * @con_length      8
	 * @con_is_notnull  true
	 */
	protected $timestamp = - 1;


	/**
	 * Log constructor
	 *
	 * @param int              $primary_key_value
	 * @param arConnector|null $connector
	 */
	public function __construct(/*int*/
		$primary_key_value = 0, /*?*/
		arConnector $connector = NULL) {
		parent::__construct($primary_key_value, $connector);
	}


	/**
	 * @param string $field_name
	 *
	 * @return mixed|null
	 */
	public function sleep(/*string*/
		$field_name) {
		$field_value = $this->{$field_name};

		switch ($field_name) {
			case "is_system":
				return ($field_value ? 1 : 0);
				break;

			default:
				return NULL;
		}
	}


	/**
	 * @param string $field_name
	 * @param mixed  $field_value
	 *
	 * @return mixed|null
	 */
	public function wakeUp(/*string*/
		$field_name, $field_value) {
		switch ($field_name) {
			case "id":
			case "from_type":
			case "from_user_id":
			case "to_user_id":
			case "context_ref_id":
			case "timestamp":
				return intval($field_value);
				break;

			case "is_system":
				return boolval($field_value);
				break;

			default:
				return NULL;
		}
	}


	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}


	/**
	 * @param int $id
	 */
	public function setId(int $id)/*: void*/ {
		$this->id = $id;
	}


	/**
	 * @return string
	 */
	public function getSubject(): string {
		return $this->subject;
	}


	/**
	 * @param string $subject
	 */
	public function setSubject(string $subject)/*: void*/ {
		$this->subject = $subject;
	}


	/**
	 * @return string
	 */
	public function getBody(): string {
		return $this->body;
	}


	/**
	 * @param string $body
	 */
	public function setBody(string $body)/*: void*/ {
		$this->body = $body;
	}


	/**
	 * @return bool
	 */
	public function isSystem(): bool {
		return $this->is_system;
	}


	/**
	 * @param bool $is_system
	 */
	public function setIsSystem(bool $is_system)/*: void*/ {
		$this->is_system = $is_system;
	}


	/**
	 * @return string
	 */
	public function getFromName(): string {
		return $this->from_name;
	}


	/**
	 * @param string $from_name
	 */
	public function setFromName(string $from_name)/*: void*/ {
		$this->from_name = $from_name;
	}


	/**
	 * @return string
	 */
	public function getFromEmail(): string {
		return $this->from_email;
	}


	/**
	 * @param string $from_email
	 */
	public function setFromEmail(string $from_email)/*: void*/ {
		$this->from_email = $from_email;
	}


	/**
	 * @return int
	 */
	public function getFromUserId(): int {
		return $this->from_user_id;
	}


	/**
	 * @param int $from_user_id
	 */
	public function setFromUserId(int $from_user_id)/*: void*/ {
		$this->from_user_id = $from_user_id;
	}


	/**
	 * @return string
	 */
	public function getToName(): string {
		return $this->to_name;
	}


	/**
	 * @param string $to_name
	 */
	public function setToName(string $to_name)/*: void*/ {
		$this->to_name = $to_name;
	}


	/**
	 * @return string
	 */
	public function getToEmail(): string {
		return $this->to_email;
	}


	/**
	 * @param string $to_email
	 */
	public function setToEmail(string $to_email)/*: void*/ {
		$this->to_email = $to_email;
	}


	/**
	 * @return int
	 */
	public function getToUserId(): int {
		return $this->to_user_id;
	}


	/**
	 * @param int $to_user_id
	 */
	public function setToUserId(int $to_user_id)/*: void*/ {
		$this->to_user_id = $to_user_id;
	}


	/**
	 * @return int
	 */
	public function getContextRefId(): int {
		return $this->context_ref_id;
	}


	/**
	 * @param int $context_ref_id
	 */
	public function setContextRefId(int $context_ref_id)/*: void*/ {
		$this->context_ref_id = $context_ref_id;
	}


	/**
	 * @return int
	 */
	public function getTimestamp(): int {
		return $this->timestamp;
	}


	/**
	 * @param int $timestamp
	 */
	public function setTimestamp(int $timestamp)/*: void*/ {
		$this->timestamp = $timestamp;
	}
}
