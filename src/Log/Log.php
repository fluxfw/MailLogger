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
	 * @param int $log_id
	 *
	 * @return Log
	 */
	public static function getLogById(int $log_id) {
		/**
		 * @var self $log
		 */

		$log = self::where([ "id" => $log_id ])->first();

		return $log;
	}


	/**
	 * @param string   $subject
	 * @param string   $body
	 * @param string   $from_email
	 * @param int|null $from_user_id
	 * @param string   $from_firstname
	 * @param string   $from_lastname
	 * @param string   $to_email
	 * @param int|null $to_user_id
	 * @param string   $to_firstname
	 * @param string   $to_lastname
	 * @param string   $context_title
	 * @param int|null $context_ref_id
	 * @param int|null $timestamp_start
	 * @param int|null $timestamp_end
	 *
	 * @return array
	 */
	public static function getLogs(string $subject = "", string $body = "", string $from_email = "", /*?*/
		int $from_user_id = NULL, string $from_firstname = "", string $from_lastname = "", string $to_email = "", /*?*/
		int $to_user_id = NULL, string $to_firstname = "", string $to_lastname = "", string $context_title = "", /*?*/
		int $context_ref_id = NULL, /*?*/
		int $timestamp_start = NULL, /*?*/
		int $timestamp_end = NULL): array {
		$where = self::where([]);

		if (!empty($subject)) {
			$where = $where->where([ "subject" => '%' . $subject . '%' ], "LIKE");
		}
		if (!empty($body)) {
			$where = $where->where([ "body" => '%' . $body . '%' ], "LIKE");
		}
		if (!empty($from_email)) {
			$where = $where->where([ "from_email" => '%' . $from_email . '%' ], "LIKE");
		}
		if (!empty($from_user_id)) {
			$where = $where->where([ "from_user_id" => $from_user_id ]);
		}
		if (!empty($from_firstname)) {
			$where = $where->where([ "from_firstname" => '%' . $from_firstname . '%' ], "LIKE");
		}
		if (!empty($from_lastname)) {
			$where = $where->where([ "from_lastname" => '%' . $from_lastname . '%' ], "LIKE");
		}
		if (!empty($to_email)) {
			$where = $where->where([ "to_email" => '%' . $to_email . '%' ], "LIKE");
		}
		if (!empty($to_user_id)) {
			$where = $where->where([ "to_user_id" => $to_user_id ]);
		}
		if (!empty($to_firstname)) {
			$where = $where->where([ "to_firstname" => '%' . $to_firstname . '%' ], "LIKE");
		}
		if (!empty($to_lastname)) {
			$where = $where->where([ "to_lastname" => '%' . $to_lastname . '%' ], "LIKE");
		}
		if (!empty($context_title)) {
			$where = $where->where([ "context_title" => '%' . $context_title . '%' ], "LIKE");
		}
		if (!empty($context_ref_id)) {
			$where = $where->where([ "context_ref_id" => $context_ref_id ]);
		}
		if (!empty($timestamp_start)) {
			$where = $where->where([ "timestamp" => $timestamp_start ], ">=");
		}
		if (!empty($timestamp_end)) {
			$where = $where->where([ "timestamp" => $timestamp_end ], "<=");
		}

		$logs = $where->getArray();

		return $logs;
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
	protected $from_email = "";
	/**
	 * @var string
	 *
	 * @con_has_field   true
	 * @con_fieldtype   text
	 * @con_is_notnull  true
	 */
	protected $from_firstname = "";
	/**
	 * @var string
	 *
	 * @con_has_field   true
	 * @con_fieldtype   text
	 * @con_is_notnull  true
	 */
	protected $from_lastname = "";
	/**
	 * @var int
	 *
	 * @con_has_field   true
	 * @con_fieldtype   integer
	 * @con_length      8
	 * @con_is_notnull  true
	 */
	protected $from_user_id;
	/**
	 * @var string
	 *
	 * @con_has_field   true
	 * @con_fieldtype   text
	 * @con_is_notnull  true
	 */
	protected $to_email = "";
	/**
	 * @var string
	 *
	 * @con_has_field   true
	 * @con_fieldtype   text
	 * @con_is_notnull  true
	 */
	protected $to_firstname = "";
	/**
	 * @var string
	 *
	 * @con_has_field   true
	 * @con_fieldtype   text
	 * @con_is_notnull  true
	 */
	protected $to_lastname = "";
	/**
	 * @var int
	 *
	 * @con_has_field   true
	 * @con_fieldtype   integer
	 * @con_length      8
	 * @con_is_notnull  true
	 */
	protected $to_user_id;
	/**
	 * @var string|null
	 *
	 * @con_has_field   true
	 * @con_fieldtype   text
	 * @con_is_notnull  false
	 */
	protected $context_title = NULL;
	/**
	 * @var int|null
	 *
	 * @con_has_field   true
	 * @con_fieldtype   integer
	 * @con_length      8
	 * @con_is_notnull  false
	 */
	protected $context_ref_id = NULL;
	/**
	 * @var int
	 *
	 * @con_has_field   true
	 * @con_fieldtype   integer
	 * @con_length      8
	 * @con_is_notnull  true
	 */
	protected $timestamp;


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
			case "timestamp":
				return intval($field_value);
				break;

			case "is_system":
				return boolval($field_value);
				break;

			case "context_ref_id":
				if ($field_value !== NULL) {
					return intval($field_value);
				} else {
					return NULL;
				}
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
	 * @return string
	 */
	public function getFromFirstname(): string {
		return $this->from_firstname;
	}


	/**
	 * @param string $from_firstname
	 */
	public function setFromFirstname(string $from_firstname)/*: void*/ {
		$this->from_firstname = $from_firstname;
	}


	/**
	 * @return string
	 */
	public function getFromLastname(): string {
		return $this->from_lastname;
	}


	/**
	 * @param string $from_lastname
	 */
	public function setFromLastname(string $from_lastname)/*: void*/ {
		$this->from_lastname = $from_lastname;
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
	 * @return string
	 */
	public function getToFirstname(): string {
		return $this->to_firstname;
	}


	/**
	 * @param string $to_firstname
	 */
	public function setToFirstname(string $to_firstname)/*: void*/ {
		$this->to_firstname = $to_firstname;
	}


	/**
	 * @return string
	 */
	public function getToLastname(): string {
		return $this->to_lastname;
	}


	/**
	 * @param string $to_lastname
	 */
	public function setToLastname(string $to_lastname)/*: void*/ {
		$this->to_lastname = $to_lastname;
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
	 * @return string|null
	 */
	public function getContextTitle()/*?: string*/ {
		return $this->context_title;
	}


	/**
	 * @param string|null $context_title
	 */
	public function setContextTitle(/*?string*/
		$context_title)/*: void*/ {
		$this->context_title = $context_title;
	}


	/**
	 * @return int|null
	 */
	public function getContextRefId()/*: ?int*/ {
		return $this->context_ref_id;
	}


	/**
	 * @param int|null $context_ref_id
	 */
	public function setContextRefId(/*?int*/
		$context_ref_id)/*: void*/ {
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
