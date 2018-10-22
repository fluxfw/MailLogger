<?php

namespace srag\AVL\Plugins\AVLMailLogger\Config;

use ilAVLMailLoggerPlugin;
use srag\ActiveRecordConfig\ActiveRecordConfigFormGUI;
use srag\AVL\Plugins\AVLMailLogger\Utils\AVLMailLoggerTrait;

/**
 * Class ConfigFormGUI
 *
 * @package srag\AVL\Plugins\AVLMailLogger\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ConfigFormGUI extends ActiveRecordConfigFormGUI {

	use AVLMailLoggerTrait;
	const PLUGIN_CLASS_NAME = ilAVLMailLoggerPlugin::class;


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
