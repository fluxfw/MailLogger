<?php

require_once __DIR__ . "/../vendor/autoload.php";

use srag\DevTools\MailLogger\DevToolsCtrl;
use srag\DIC\MailLogger\DICTrait;
use srag\Plugins\MailLogger\Config\ConfigCtrl;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class ilMailLoggerConfigGUI
 *
 * @ilCtrl_isCalledBy srag\DevTools\MailLogger\DevToolsCtrl: ilMailLoggerConfigGUI
 */
class ilMailLoggerConfigGUI extends ilPluginConfigGUI
{

    use DICTrait;
    use MailLoggerTrait;

    const CMD_CONFIGURE = "configure";
    const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;


    /**
     * ilMailLoggerConfigGUI constructor
     */
    public function __construct()
    {

    }


    /**
     * @inheritDoc
     */
    public function performCommand(/*string*/ $cmd) : void
    {
        $this->setTabs();

        $next_class = self::dic()->ctrl()->getNextClass($this);

        switch (strtolower($next_class)) {
            case strtolower(ConfigCtrl::class):
                self::dic()->ctrl()->forwardCommand(new ConfigCtrl());
                break;

            case strtolower(DevToolsCtrl::class):
                self::dic()->ctrl()->forwardCommand(new DevToolsCtrl($this, self::plugin()));
                break;

            default:
                $cmd = self::dic()->ctrl()->getCmd();

                switch ($cmd) {
                    case self::CMD_CONFIGURE:
                        $this->{$cmd}();
                        break;

                    default:
                        break;
                }
                break;
        }
    }


    /**
     *
     */
    protected function configure() : void
    {
        self::dic()->ctrl()->redirectByClass(ConfigCtrl::class, ConfigCtrl::CMD_CONFIGURE);
    }


    /**
     *
     */
    protected function setTabs() : void
    {
        ConfigCtrl::addTabs();

        DevToolsCtrl::addTabs(self::plugin());

        self::dic()->locator()->addItem(ilMailLoggerPlugin::PLUGIN_NAME, self::dic()->ctrl()->getLinkTarget($this, self::CMD_CONFIGURE));
    }
}
