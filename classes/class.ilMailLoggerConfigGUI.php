<?php

require_once __DIR__ . "/../vendor/autoload.php";

use srag\DIC\MailLogger\DICTrait;
use srag\Plugins\MailLogger\Config\ConfigCtrl;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class ilMailLoggerConfigGUI
 *
 * @author studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ilMailLoggerConfigGUI extends ilPluginConfigGUI
{

    use DICTrait;
    use MailLoggerTrait;
    const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
    const CMD_CONFIGURE = "configure";


    /**
     * ilMailLoggerConfigGUI constructor
     */
    public function __construct()
    {

    }


    /**
     * @inheritDoc
     */
    public function performCommand(/*string*/ $cmd)/*:void*/
    {
        $this->setTabs();

        $next_class = self::dic()->ctrl()->getNextClass($this);

        switch (strtolower($next_class)) {
            case strtolower(ConfigCtrl::class):
                self::dic()->ctrl()->forwardCommand(new ConfigCtrl());
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
    protected function setTabs()/*: void*/
    {
        ConfigCtrl::addTabs();

        self::dic()->locator()->addItem(ilMailLoggerPlugin::PLUGIN_NAME, self::dic()->ctrl()->getLinkTarget($this, self::CMD_CONFIGURE));
    }


    /**
     *
     */
    protected function configure()/*: void*/
    {
        self::dic()->ctrl()->redirectByClass(ConfigCtrl::class, ConfigCtrl::CMD_CONFIGURE);
    }
}
