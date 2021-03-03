<?php

require_once __DIR__ . "/../vendor/autoload.php";

use ILIAS\DI\Container;
use ILIAS\GlobalScreen\Scope\MainMenu\Provider\AbstractStaticPluginMainMenuProvider;
use srag\CustomInputGUIs\MailLogger\Loader\CustomInputGUIsLoaderDetector;
use srag\DevTools\MailLogger\DevToolsCtrl;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;
use srag\RemovePluginDataConfirm\MailLogger\PluginUninstallTrait;

/**
 * Class ilMailLoggerPlugin
 *
 * @author studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ilMailLoggerPlugin extends ilEventHookPlugin
{

    use PluginUninstallTrait;
    use MailLoggerTrait;

    const COMPONENT_MAIL = "Services/Mail";
    const EVENT_SENT_EXTERNAL_MAIL = "externalEmailDelegated";
    const EVENT_SENT_INTERNAL_MAIL = "sentInternalMail";
    const PLUGIN_CLASS_NAME = self::class;
    const PLUGIN_ID = "maillog";
    const PLUGIN_NAME = "MailLogger";
    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * ilMailLoggerPlugin constructor
     */
    public function __construct()
    {
        parent::__construct();
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
     * @inheritDoc
     */
    public function exchangeUIRendererAfterInitialization(Container $dic) : Closure
    {
        return CustomInputGUIsLoaderDetector::exchangeUIRendererAfterInitialization();
    }


    /**
     * @inheritDoc
     */
    public function getPluginName() : string
    {
        return self::PLUGIN_NAME;
    }


    /**
     * @inheritDoc
     */
    public function handleEvent(/*string*/ $a_component, /*string*/ $a_event, /*array*/ $a_parameter)/*: void*/
    {
        switch ($a_component) {
            case "Services/Mail":
                switch ($a_event) {
                    case self::EVENT_SENT_INTERNAL_MAIL:
                        $mail = $a_parameter;
                        self::mailLogger()->logs()->handler()->handleSentInternalEmail($mail);
                        break;

                    case self::EVENT_SENT_EXTERNAL_MAIL:
                        $mail = $a_parameter["mail"];
                        self::mailLogger()->logs()->handler()->handleSentExternalEmail($mail);
                        break;

                    default:
                        break;
                }
                break;

            default:
                break;
        }
    }


    /**
     * @inheritDoc
     */
    public function promoteGlobalScreenProvider() : AbstractStaticPluginMainMenuProvider
    {
        return self::mailLogger()->menu();
    }


    /**
     * @inheritDoc
     */
    public function updateLanguages(/*?array*/ $a_lang_keys = null)/*:void*/
    {
        parent::updateLanguages($a_lang_keys);

        $this->installRemovePluginDataConfirmLanguages();

        DevToolsCtrl::installLanguages(self::plugin());
    }


    /**
     * @inheritDoc
     */
    protected function deleteData()/*: void*/
    {
        self::mailLogger()->dropTables();
    }


    /**
     * @inheritDoc
     */
    protected function shouldUseOneUpdateStepOnly() : bool
    {
        return true;
    }
}
