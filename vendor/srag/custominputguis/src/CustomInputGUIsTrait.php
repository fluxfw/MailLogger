<?php

namespace srag\CustomInputGUIs\MailLogger;

/**
 * Trait CustomInputGUIsTrait
 *
 * @package srag\CustomInputGUIs\MailLogger
 */
trait CustomInputGUIsTrait
{

    /**
     * @return CustomInputGUIs
     */
    protected static final function customInputGUIs() : CustomInputGUIs
    {
        return CustomInputGUIs::getInstance();
    }
}
