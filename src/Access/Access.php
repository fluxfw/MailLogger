<?php

namespace srag\AVL\Plugins\MailLogger\Access;

use ilMailLoggerPlugin;
use srag\AVL\Plugins\MailLogger\Utils\MailLoggerTrait;
use srag\DIC\MailLogger\DICTrait;

/**
 * Class Access
 *
 * @package srag\AVL\Plugins\MailLogger\Access
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Access {

	use DICTrait;
	use MailLoggerTrait;
	const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
	const ADMIN_ROLE_ID = 2;
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
	 * Access constructor
	 */
	public function __construct() {

	}


	/**
	 * @return bool
	 */
	public function hasLogAccess(): bool {
		return self::dic()->rbacreview()->isAssigned(self::dic()->user()->getId(), self::ADMIN_ROLE_ID);
	}
}
