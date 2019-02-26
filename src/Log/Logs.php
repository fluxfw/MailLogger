<?php

namespace srag\Plugins\MailLogger\Logs;

use ilMailLoggerPlugin;
use srag\DIC\MailLogger\DICTrait;
use srag\Plugins\MailLogger\Log\Log;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class Logs
 *
 * @package srag\Plugins\MailLogger\Logs
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Logs {

	use DICTrait;
	use MailLoggerTrait;
	const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
	/**
	 * @var self
	 */
	protected static $instance = NULL;


	/**
	 * @return self
	 */
	public static function getInstance(): self {
		if (self::$instance === NULL) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * Logs constructor
	 */
	private function __construct() {

	}


	/**
	 * @param int $log_id
	 *
	 * @return Log|null
	 */
	public function getLogById(int $log_id)/*: ?Log*/ {
		/**
		 * @var Log|null $log
		 */

		$log = Log::where([ "id" => $log_id ])->first();

		return $log;
	}


	/**
	 * @param string   $subject
	 * @param string   $body
	 * @param string   $from_email
	 * @param string   $from_firstname
	 * @param string   $from_lastname
	 * @param string   $to_email
	 * @param string   $to_firstname
	 * @param string   $to_lastname
	 * @param string   $context_title
	 * @param int|null $context_ref_id
	 * @param int|null $timestamp_start
	 * @param int|null $timestamp_end
	 *
	 * @return array
	 */
	public function getLogs(string $subject = "", string $body = "", string $from_email = "", string $from_firstname = "", string $from_lastname = "", string $to_email = "", string $to_firstname = "", string $to_lastname = "", string $context_title = "", /*?*/
		int $context_ref_id = NULL, /*?*/
		int $timestamp_start = NULL, /*?*/
		int $timestamp_end = NULL): array {
		$where = Log::where([]);

		if (!empty($subject)) {
			$where = $where->where([ "subject" => '%' . $subject . '%' ], "LIKE");
		}
		if (!empty($from_email)) {
			$where = $where->where([ "from_email" => '%' . $from_email . '%' ], "LIKE");
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

		if (!empty($body)) {
			$logs = array_filter($logs, function (array $log) use ($body): bool {
				// Remove possible html before filter by body
				return (stripos(strip_tags($log["body"]), $body) !== false);
			});
		}

		return $logs;
	}
}
