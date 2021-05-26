<?php

namespace srag\Plugins\MailLogger\Utils;

use srag\Plugins\MailLogger\Repository;

/**
 * Trait MailLoggerTrait
 *
 * @package srag\Plugins\MailLogger\Utils
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
