<?php

namespace srag\DIC\MailLogger\DIC;

use ILIAS\DI\Container;
use srag\DIC\MailLogger\Database\DatabaseDetector;
use srag\DIC\MailLogger\Database\DatabaseInterface;

/**
 * Class AbstractDIC
 *
 * @package srag\DIC\MailLogger\DIC
 */
abstract class AbstractDIC implements DICInterface
{

    /**
     * @var Container
     */
    protected $dic;


    /**
     * @inheritDoc
     */
    public function __construct(Container &$dic)
    {
        $this->dic = &$dic;
    }


    /**
     * @inheritDoc
     */
    public function database() : DatabaseInterface
    {
        return DatabaseDetector::getInstance($this->databaseCore());
    }
}
