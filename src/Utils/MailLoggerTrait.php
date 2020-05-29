<?php

namespace srag\Plugins\MailLogger\Utils;

use srag\Plugins\MailLogger\Repository;

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
     * @return Repository
     */
    protected static function mailLogger() : Repository
    {
        return Repository::getInstance();
    }
}
