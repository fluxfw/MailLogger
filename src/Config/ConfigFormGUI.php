<?php

namespace srag\Plugins\MailLogger\Config;

use ilCheckboxInputGUI;
use ilMailLoggerPlugin;
use srag\ActiveRecordConfig\MailLogger\ActiveRecordConfigFormGUI;
use srag\CustomInputGUIs\MailLogger\MultiSelectSearchInputGUI\MultiSelectSearchInputGUI;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class ConfigFormGUI
 *
 * @package srag\Plugins\MailLogger\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ConfigFormGUI extends ActiveRecordConfigFormGUI
{

    use MailLoggerTrait;
    const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
    const CONFIG_CLASS_NAME = Config::class;


    /**
     * @inheritdoc
     */
    protected function initFields()/*: void*/
    {
        $this->fields = [
            Config::KEY_LOG_EMAIL_OF_USERS => [
                self::PROPERTY_CLASS    => MultiSelectSearchInputGUI::class,
                self::PROPERTY_REQUIRED => true,
                self::PROPERTY_OPTIONS  => self::ilias()->users()->getUsers()
            ],
            Config::KEY_LOG_SYSTEM_EMAILS  => [
                self::PROPERTY_CLASS => ilCheckboxInputGUI::class
            ]
        ];
    }
}
