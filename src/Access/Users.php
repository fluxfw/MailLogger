<?php

namespace srag\Plugins\MailLogger\Access;

use ilDBConstants;
use ilMailLoggerPlugin;
use srag\DIC\MailLogger\DICTrait;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class Users
 *
 * @package srag\Plugins\MailLogger\Access
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Users {

	use DICTrait;
	use MailLoggerTrait;
	const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
	/**
	 * @var self
	 */
	protected static $instance = null;


	/**
	 * @return self
	 */
	public static function getInstance(): self {
		if (self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * Users constructor
	 */
	private function __construct() {

	}


	/**
	 * @return array
	 */
	public function getUsers(): array {
		$result = self::dic()->database()->queryF('SELECT usr_id, firstname, lastname FROM usr_data WHERE active=%s', [
			ilDBConstants::T_INTEGER
		], [ 1 ]);

		$array = [];

		while (($row = $result->fetchAssoc()) !== false) {
			$array[$row["usr_id"]] = $row["lastname"] . ", " . $row["firstname"];
		}

		return $array;
	}
}
