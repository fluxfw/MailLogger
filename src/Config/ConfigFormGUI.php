<?php

namespace srag\Plugins\MailLogger\Config;

use ilCheckboxInputGUI;
use ilMailLoggerConfigGUI;
use ilMailLoggerPlugin;
use srag\CustomInputGUIs\MailLogger\MultiSelectSearchInputGUI\MultiSelectSearchInputGUI;
use srag\CustomInputGUIs\MailLogger\PropertyFormGUI\PropertyFormGUI;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class ConfigFormGUI
 *
 * @package srag\Plugins\MailLogger\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ConfigFormGUI extends PropertyFormGUI
{

    use MailLoggerTrait;
    const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
    const KEY_LOG_EMAIL_OF_USERS = "log_email_of_users";
    const KEY_LOG_SYSTEM_EMAILS = "log_system_emails";
    const LANG_MODULE = ilMailLoggerConfigGUI::LANG_MODULE;


    /**
     * ConfigFormGUI constructor
     *
     * @param ilMailLoggerConfigGUI $parent
     */
    public function __construct(ilMailLoggerConfigGUI $parent)
    {
        parent::__construct($parent);
    }


    /**
     * @inheritDoc
     */
    protected function getValue(/*string*/ $key)
    {
        switch ($key) {
            default:
                return self::mailLogger()->config()->getField($key);
        }
    }


    /**
     * @inheritDoc
     */
    protected function initCommands()/*: void*/
    {
        $this->addCommandButton(ilMailLoggerConfigGUI::CMD_UPDATE_CONFIGURE, $this->txt("save"));
    }


    /**
     * @inheritDoc
     */
    protected function initFields()/*: void*/
    {
        $this->fields = [
            self::KEY_LOG_EMAIL_OF_USERS => [
                self::PROPERTY_CLASS    => MultiSelectSearchInputGUI::class,
                self::PROPERTY_REQUIRED => true,
                self::PROPERTY_OPTIONS  => self::mailLogger()->ilias()->users()->getUsers()
            ],
            self::KEY_LOG_SYSTEM_EMAILS  => [
                self::PROPERTY_CLASS => ilCheckboxInputGUI::class
            ]
        ];
    }


    /**
     * @inheritDoc
     */
    protected function initId()/*: void*/
    {

    }


    /**
     * @inheritDoc
     */
    protected function initTitle()/*: void*/
    {
        $this->setTitle($this->txt("configuration"));
    }


    /**
     * @inheritDoc
     */
    protected function storeValue(/*string*/ $key, $value)/*: void*/
    {
        switch ($key) {
            default:
                self::mailLogger()->config()->setField($key, $value);
                break;
        }
    }
}
