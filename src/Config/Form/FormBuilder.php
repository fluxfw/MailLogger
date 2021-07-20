<?php

namespace srag\Plugins\MailLogger\Config\Form;

use ilMailLoggerPlugin;
use srag\CustomInputGUIs\MailLogger\FormBuilder\AbstractFormBuilder;
use srag\CustomInputGUIs\MailLogger\InputGUIWrapperUIInputComponent\InputGUIWrapperUIInputComponent;
use srag\CustomInputGUIs\MailLogger\MultiSelectSearchNewInputGUI\MultiSelectSearchNewInputGUI;
use srag\Plugins\MailLogger\Config\ConfigCtrl;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class FormBuilder
 *
 * @package srag\Plugins\MailLogger\Config\Form
 */
class FormBuilder extends AbstractFormBuilder
{

    use MailLoggerTrait;

    const KEY_LOG_EMAIL_OF_USERS = "log_email_of_users";
    const KEY_LOG_SYSTEM_EMAILS = "log_system_emails";
    const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;


    /**
     * @inheritDoc
     *
     * @param ConfigCtrl $parent
     */
    public function __construct(ConfigCtrl $parent)
    {
        parent::__construct($parent);
    }


    /**
     * @inheritDoc
     */
    protected function getButtons() : array
    {
        $buttons = [
            ConfigCtrl::CMD_UPDATE_CONFIGURE => self::plugin()->translate("save", ConfigCtrl::LANG_MODULE)
        ];

        return $buttons;
    }


    /**
     * @inheritDoc
     */
    protected function getData() : array
    {
        $data = [
            self::KEY_LOG_EMAIL_OF_USERS => self::mailLogger()->config()->getValue(self::KEY_LOG_EMAIL_OF_USERS),
            self::KEY_LOG_SYSTEM_EMAILS  => self::mailLogger()->config()->getValue(self::KEY_LOG_SYSTEM_EMAILS)
        ];

        return $data;
    }


    /**
     * @inheritDoc
     */
    protected function getFields() : array
    {
        $fields = [
            self::KEY_LOG_EMAIL_OF_USERS => (new InputGUIWrapperUIInputComponent(new MultiSelectSearchNewInputGUI(self::plugin()
                ->translate(self::KEY_LOG_EMAIL_OF_USERS, ConfigCtrl::LANG_MODULE))))->withByline(self::plugin()
                ->translate(self::KEY_LOG_EMAIL_OF_USERS . "_info", ConfigCtrl::LANG_MODULE))->withRequired(true),
            self::KEY_LOG_SYSTEM_EMAILS  => self::dic()->ui()->factory()->input()->field()->checkbox(self::plugin()
                ->translate(self::KEY_LOG_SYSTEM_EMAILS, ConfigCtrl::LANG_MODULE), self::plugin()
                ->translate(self::KEY_LOG_SYSTEM_EMAILS . "_info", ConfigCtrl::LANG_MODULE))->withRequired(true)
        ];
        $fields[self::KEY_LOG_EMAIL_OF_USERS]->getInput()->setOptions(self::mailLogger()->ilias()->users()->getUsers());

        return $fields;
    }


    /**
     * @inheritDoc
     */
    protected function getTitle() : string
    {
        return self::plugin()->translate("configuration", ConfigCtrl::LANG_MODULE);
    }


    /**
     * @inheritDoc
     */
    protected function storeData(array $data) : void
    {
        self::mailLogger()->config()->setValue(self::KEY_LOG_EMAIL_OF_USERS, MultiSelectSearchNewInputGUI::cleanValues((array) $data[self::KEY_LOG_EMAIL_OF_USERS]));
        self::mailLogger()->config()->setValue(self::KEY_LOG_SYSTEM_EMAILS, boolval($data[self::KEY_LOG_SYSTEM_EMAILS]));
    }
}
