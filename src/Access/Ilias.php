<?php

namespace srag\AVL\Plugins\MailLogger\Access;

use ilMailLoggerPlugin;
use srag\AVL\Plugins\MailLogger\Utils\MailLoggerTrait;
use srag\DIC\DICTrait;

/**
 * Class Ilias
 *
 * @package srag\AVL\Plugins\MailLogger\Access
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Ilias {

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
	 * Ilias constructor
	 */
	private function __construct() {

	}


	/**
	 * @return Users
	 */
	public function users(): Users {
		return Users::getInstance();
	}
}
