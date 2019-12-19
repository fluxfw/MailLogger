<?php

namespace srag\Plugins\MailLogger\Utils;

use srag\Plugins\MailLogger\Access\Access;
use srag\Plugins\MailLogger\Access\Ilias;
use srag\Plugins\MailLogger\Log\LogHandler;
use srag\Plugins\MailLogger\Logs\Logs;

/**
 * Trait MailLoggerTrait
 *
 * @package srag\Plugins\MailLogger\Utils
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
trait MailLoggerTrait
{

    /**
     * @return Access
     */
    protected static function access() : Access
    {
        return Access::getInstance();
    }


    /**
     * @return Ilias
     */
    protected static function ilias() : Ilias
    {
        return Ilias::getInstance();
    }


    /**
     * @return LogHandler
     */
    protected static function logHandler() : LogHandler
    {
        return LogHandler::getInstance();
    }


    /**
     * @return Logs
     */
    protected static function logs() : Logs
    {
        return Logs::getInstance();
    }
}
