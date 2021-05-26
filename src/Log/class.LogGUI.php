<?php

namespace srag\Plugins\MailLogger\Log;

require_once __DIR__ . "/../../vendor/autoload.php";

use ilMailLoggerPlugin;
use srag\DIC\MailLogger\DICTrait;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class LogGUI
 *
 * @package           srag\Plugins\MailLogger\Log
 *
 * @ilCtrl_isCalledBy srag\Plugins\MailLogger\Log\LogGUI: ilUIPluginRouterGUI
 */
class LogGUI
{

    use DICTrait;
    use MailLoggerTrait;

    const CMD_APPLY_FILTER = "applyFilter";
    const CMD_LIST_LOGS = "listLogs";
    const CMD_RESET_FILTER = "resetFilter";
    const CMD_SHOW_EMAIL = "showEmail";
    const GET_PARAM_LOG_ID = "log_id";
    const LANG_MODULE = "log";
    const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
    /**
     * @var Log|null
     */
    protected $log = null;


    /**
     * LogGUI constructor
     */
    public function __construct()
    {

    }


    /**
     *
     */
    public function executeCommand()/*: void*/
    {
        $this->log = self::mailLogger()->logs()->getLogById(intval(filter_input(INPUT_GET, self::GET_PARAM_LOG_ID)));

        if (!self::mailLogger()->access()->hasLogAccess()) {
            die();
        }

        //self::dic()->ctrl()->saveParameter($this, self::GET_PARAM_LOG_ID);

        $this->setTabs();

        $next_class = self::dic()->ctrl()->getNextClass($this);

        switch (strtolower($next_class)) {
            default:
                $cmd = self::dic()->ctrl()->getCmd();

                switch ($cmd) {
                    case self::CMD_APPLY_FILTER:
                    case self::CMD_LIST_LOGS:
                    case self::CMD_RESET_FILTER:
                    case self::CMD_SHOW_EMAIL:
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
    protected function applyFilter()/*: void*/
    {
        $table = self::mailLogger()->logs()->factory()->newTableInstance($this, self::CMD_APPLY_FILTER);

        $table->writeFilterToSession();

        $table->resetOffset();

        //self::dic()->ctrl()->redirect($this, self::CMD_LIST_LOG);
        $this->listLogs(); // Fix reset offset
    }


    /**
     *
     */
    protected function listLogs()/*: void*/
    {
        $table = self::mailLogger()->logs()->factory()->newTableInstance($this);

        self::output()->output($table, true);
    }


    /**
     *
     */
    protected function resetFilter()/*: void*/
    {
        $table = self::mailLogger()->logs()->factory()->newTableInstance($this, self::CMD_RESET_FILTER);

        $table->resetFilter();

        $table->resetOffset();

        //self::dic()->ctrl()->redirect($this, self::CMD_LIST_LOG);
        $this->listLogs(); // Fix reset offset
    }


    /**
     *
     */
    protected function setTabs()/*:void*/
    {

    }


    /**
     *
     */
    protected function showEmail()/*: void*/
    {
        self::dic()->tabs()->setBackTarget(self::plugin()->translate("back", self::LANG_MODULE), self::dic()->ctrl()
            ->getLinkTarget($this, self::CMD_LIST_LOGS));

        if ($this->log !== null) {
            $form = self::mailLogger()->logs()->factory()->newFormBuilderInstance($this, $this->log);

            self::output()->output($form, true);
        } else {
            self::output()->output("", true);
        }
    }
}
