<?php

namespace srag\AVL\Plugins\MailLogger\Config;

use ilCheckboxInputGUI;
use ilMailLoggerPlugin;
use srag\ActiveRecordConfig\ActiveRecordConfigFormGUI;
use srag\AVL\Plugins\MailLogger\Utils\MailLoggerTrait;
use srag\CustomInputGUIs\MultiSelectSearchInputGUI\MultiSelectSearchInputGUI;

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

		$users = self::access()->getUsers();

		$log_email_of_users = new MultiSelectSearchInputGUI($this->txt(Config::KEY_LOG_EMAIL_OF_USERS), Config::KEY_LOG_EMAIL_OF_USERS);
		$log_email_of_users->setRequired(true);
		$log_email_of_users->setInfo($this->txt(Config::KEY_LOG_EMAIL_OF_USERS . "_info"));
		$log_email_of_users->setOptions($users);
		$log_email_of_users->setValue(Config::getLogEmailOfUsers());
		$this->addItem($log_email_of_users);

		$log_system_emails = new ilCheckboxInputGUI($this->txt(Config::KEY_LOG_SYSTEM_EMAILS), Config::KEY_LOG_SYSTEM_EMAILS);
		$log_system_emails->setInfo($this->txt(Config::KEY_LOG_SYSTEM_EMAILS . "_info"));
		$log_system_emails->setChecked(Config::getLogSystemEmails());
		$this->addItem($log_system_emails);
	}


	/**
	 * @inheritdoc
	 */
	public function updateConfig()/*: void*/ {
		$log_email_of_users = $this->getInput(Config::KEY_LOG_EMAIL_OF_USERS);
		if (!is_array($log_email_of_users)) {
			$log_email_of_users = [];
		}
		Config::setLogEmailOfUsers($log_email_of_users);

		$log_system_emails = boolval($this->getInput(Config::KEY_LOG_SYSTEM_EMAILS));
		Config::setLogSystemEmails($log_system_emails);
	}
}
