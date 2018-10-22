<?php

require_once __DIR__ . "/../vendor/autoload.php";

use srag\AVL\Plugins\MailLogger\Config\Config;
use srag\AVL\Plugins\MailLogger\Utils\MailLoggerTrait;
use srag\RemovePluginDataConfirm\PluginUninstallTrait;

/**
 * Class ilMailLoggerPlugin
 *
 * @author studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ilMailLoggerPlugin extends ilEventHookPlugin {

	use PluginUninstallTrait;
	use MailLoggerTrait;
	const PLUGIN_ID = "maillog";
	const PLUGIN_NAME = "MailLogger";
	const PLUGIN_CLASS_NAME = self::class;
	const REMOVE_PLUGIN_DATA_CONFIRM_CLASS_NAME = MailLoggerRemoveDataConfirm::class;
	/**
	 * @var self|null
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
	 * ilMailLoggerPlugin constructor
	 */
	public function __construct() {
		parent::__construct();
	}


	/**
	 * @return string
	 */
	public function getPluginName(): string {
		return self::PLUGIN_NAME;
	}


	/**
	 * @param string $a_component
	 * @param string $a_event
	 * @param array  $a_parameter
	 */
	public function handleEvent(/*string*/
		$a_component, /*string*/
		$a_event,/*array*/
		$a_parameter)/*: void*/ {
		// TODO: Implement handleEvent
	}


	/**
	 * @inheritdoc
	 */
	protected function deleteData()/*: void*/ {
		self::dic()->database()->dropTable(Config::TABLE_NAME, false);
	}
}
