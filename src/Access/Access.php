<?php

namespace srag\Plugins\MailLogger\Access;

use ilMailLoggerPlugin;
use srag\DIC\MailLogger\DICTrait;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class Access
 *
 * @package srag\Plugins\MailLogger\Access
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Access
{

    use DICTrait;
    use MailLoggerTrait;
    const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
    const ADMIN_ROLE_ID = 2;
    /**
     * @var self|null
     */
    protected static $instance = null;


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
     * Access constructor
     */
    private function __construct()
    {

    }


    /**
     * @return bool
     */
    public function hasLogAccess() : bool
    {
        return (self::plugin()->getPluginObject()->isActive() && self::dic()->rbac()->review()->isAssigned(self::dic()->user()->getId(), self::ADMIN_ROLE_ID));
    }
}
