<?php

namespace srag\Plugins\MailLogger\Access;

use ilMailLoggerPlugin;
use srag\DIC\MailLogger\DICTrait;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class Ilias
 *
 * @package srag\Plugins\MailLogger\Access
 */
final class Ilias
{

    use DICTrait;
    use MailLoggerTrait;

    const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * Ilias constructor
     */
    private function __construct()
    {

    }


    /**
     * @return self
     */
    public static function getInstance() : self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * @return Users
     */
    public function users() : Users
    {
        return Users::getInstance();
    }
}
