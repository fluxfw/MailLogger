<?php

namespace srag\AVL\Plugins\MailLogger\Config;

use ilMailLoggerPlugin;
use srag\ActiveRecordConfig\ActiveRecordConfigFormGUI;
use srag\AVL\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class ConfigFormGUI
 *
 * @package srag\AVL\Plugins\MailLogger\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ConfigFormGUI extends ActiveRecordConfigFormGUI {

	use MailLoggerTrait;
	const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;


	/**
	 * @inheritdoc
	 */
	protected function initForm()/*: void*/ {
		parent::initForm();
	}


	/**
	 * @inheritdoc
	 */
	public function updateConfig()/*: void*/ {

	}
}
