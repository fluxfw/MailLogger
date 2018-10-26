<?php

namespace srag\AVL\Plugins\MailLogger\Log;

use ilAdvancedSelectionListGUI;
use ilCSVWriter;
use ilDatePresentation;
use ilDateTime;
use ilExcel;
use ilMailLoggerPlugin;
use ilTable2GUI;
use ilTextInputGUI;
use MailLoggerLogGUI;
use srag\AVL\Plugins\MailLogger\Utils\MailLoggerTrait;
use srag\CustomInputGUIs\DateDurationInputGUI\DateDurationInputGUI;
use srag\CustomInputGUIs\NumberInputGUI\NumberInputGUI;
use srag\DIC\DICTrait;

/**
 * Class LogTableGUI
 *
 * @package srag\AVL\Plugins\MailLogger\Log
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class LogTableGUI extends ilTable2GUI {

	use DICTrait;
	use MailLoggerTrait;
	const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
	/**
	 * @var ilTextInputGUI
	 */
	protected $filter_subject;
	/**
	 * @var ilTextInputGUI
	 */
	protected $filter_body;
	/**
	 * @var ilTextInputGUI
	 */
	protected $filter_from_email;
	/**
	 * @var NumberInputGUI
	 */
	protected $filter_from_user_id;
	/**
	 * @var ilTextInputGUI
	 */
	protected $filter_from_firstname;
	/**
	 * @var ilTextInputGUI
	 */
	protected $filter_from_lastname;
	/**
	 * @var ilTextInputGUI
	 */
	protected $filter_to_email;
	/**
	 * @var NumberInputGUI
	 */
	protected $filter_to_user_id;
	/**
	 * @var ilTextInputGUI
	 */
	protected $filter_to_firstname;
	/**
	 * @var ilTextInputGUI
	 */
	protected $filter_to_lastname;
	/**
	 * @var ilTextInputGUI
	 */
	protected $filter_context_title;
	/**
	 * @var NumberInputGUI
	 */
	protected $filter_context_ref_id;
	/**
	 * @var DateDurationInputGUI
	 */
	protected $filter_timestamp;


	/**
	 * LogTableGUI constructor
	 *
	 * @param MailLoggerLogGUI $parent
	 * @param string           $parent_cmd
	 */
	public function __construct(MailLoggerLogGUI $parent, string $parent_cmd) {
		$this->setId("maillogger_log");

		parent::__construct($parent, $parent_cmd);

		if (!($parent_cmd === MailLoggerLogGUI::CMD_APPLY_FILTER || $parent_cmd === MailLoggerLogGUI::CMD_RESET_FILTER)) {
			$this->initTable();
		} else {
			$this->initFilter();
		}
	}


	/**
	 *
	 */
	protected function initTable() {
		$parent = $this->getParentObject();

		$this->setFormAction(self::dic()->ctrl()->getFormAction($parent));

		$this->setTitle(self::plugin()->translate("log", MailLoggerLogGUI::CMD_LOG));

		$this->initFilter();

		$this->initData();

		$this->initColumns();

		$this->initExport();

		$this->setRowTemplate("log_table_row.html", self::plugin()->directory());
	}


	/**
	 *
	 */
	public function initFilter()/*: void*/ {
		$this->filter_subject = new ilTextInputGUI(self::plugin()->translate("subject", MailLoggerLogGUI::LANG_MODULE_LOG), "subject");
		$this->addFilterItem($this->filter_subject);
		$this->filter_subject->readFromSession();

		$this->filter_body = new ilTextInputGUI(self::plugin()->translate("body", MailLoggerLogGUI::LANG_MODULE_LOG), "body");
		$this->addFilterItem($this->filter_body);
		$this->filter_body->readFromSession();

		$this->filter_from_email = new ilTextInputGUI(self::plugin()->translate("from_email", MailLoggerLogGUI::LANG_MODULE_LOG), "from_email");
		$this->addFilterItem($this->filter_from_email);
		$this->filter_from_email->readFromSession();

		$this->filter_from_user_id = new NumberInputGUI(self::plugin()->translate("from_user_id", MailLoggerLogGUI::LANG_MODULE_LOG), "from_user_id");
		$this->filter_from_user_id->setMinValue(1);
		$this->addFilterItem($this->filter_from_user_id);
		$this->filter_from_user_id->readFromSession();

		$this->filter_from_firstname = new ilTextInputGUI(self::plugin()
			->translate("from_firstname", MailLoggerLogGUI::LANG_MODULE_LOG), "from_firstname");
		$this->addFilterItem($this->filter_from_firstname);
		$this->filter_from_firstname->readFromSession();

		$this->filter_from_lastname = new ilTextInputGUI(self::plugin()
			->translate("from_lastname", MailLoggerLogGUI::LANG_MODULE_LOG), "from_lastname");
		$this->addFilterItem($this->filter_from_lastname);
		$this->filter_from_lastname->readFromSession();

		$this->filter_to_email = new ilTextInputGUI(self::plugin()->translate("to_email", MailLoggerLogGUI::LANG_MODULE_LOG), "to_email");
		$this->addFilterItem($this->filter_to_email);
		$this->filter_to_email->readFromSession();

		$this->filter_to_user_id = new NumberInputGUI(self::plugin()->translate("to_user_id", MailLoggerLogGUI::LANG_MODULE_LOG), "to_user_id");
		$this->filter_to_user_id->setMinValue(1);
		$this->addFilterItem($this->filter_to_user_id);
		$this->filter_to_user_id->readFromSession();

		$this->filter_to_firstname = new ilTextInputGUI(self::plugin()->translate("to_firstname", MailLoggerLogGUI::LANG_MODULE_LOG), "to_firstname");
		$this->addFilterItem($this->filter_to_firstname);
		$this->filter_to_firstname->readFromSession();

		$this->filter_to_lastname = new ilTextInputGUI(self::plugin()->translate("to_lastname", MailLoggerLogGUI::LANG_MODULE_LOG), "to_lastname");
		$this->addFilterItem($this->filter_to_lastname);
		$this->filter_to_lastname->readFromSession();

		$this->filter_context_title = new ilTextInputGUI(self::plugin()
			->translate("context_title", MailLoggerLogGUI::LANG_MODULE_LOG), "context_title");
		$this->addFilterItem($this->filter_context_title);
		$this->filter_context_title->readFromSession();

		$this->filter_context_ref_id = new NumberInputGUI(self::plugin()
			->translate("context_ref_id", MailLoggerLogGUI::LANG_MODULE_LOG), "context_ref_id");
		$this->filter_context_ref_id->setMinValue(1);
		$this->addFilterItem($this->filter_context_ref_id);
		$this->filter_context_ref_id->readFromSession();

		self::dic()->language()->loadLanguageModule("form");
		$this->filter_timestamp = new DateDurationInputGUI(self::plugin()->translate("timestamp", MailLoggerLogGUI::LANG_MODULE_LOG), "timestamp");
		$this->filter_timestamp->setShowTime(true);
		$this->addFilterItem($this->filter_timestamp);
		$this->filter_timestamp->readFromSession();

		$this->setDisableFilterHiding(true);
	}


	/**
	 *
	 */
	protected function initData()/*: void*/ {
		$subject = $this->filter_subject->getValue();
		if ($subject === false) {
			$subject = "";
		}
		$body = $this->filter_body->getValue();
		if ($body === false) {
			$body = "";
		}
		$from_email = $this->filter_from_email->getValue();
		if ($from_email === false) {
			$from_email = "";
		}
		$from_user_id = $this->filter_from_user_id->getValue();
		if ($from_user_id !== false) {
			$from_user_id = intval($from_user_id);
		} else {
			$from_user_id = NULL;
		}
		$from_firstname = $this->filter_from_firstname->getValue();
		if ($from_email === false) {
			$from_email = "";
		}
		$from_lastname = $this->filter_from_lastname->getValue();
		if ($from_email === false) {
			$from_email = "";
		}
		$to_email = $this->filter_to_email->getValue();
		if ($to_email === false) {
			$to_email = "";
		}
		$to_user_id = $this->filter_to_user_id->getValue();
		if ($to_user_id !== false) {
			$to_user_id = intval($to_user_id);
		} else {
			$to_user_id = NULL;
		}
		$to_firstname = $this->filter_to_firstname->getValue();
		if ($to_email === false) {
			$to_email = "";
		}
		$to_lastname = $this->filter_to_lastname->getValue();
		if ($to_email === false) {
			$to_email = "";
		}
		$context_title = $this->filter_context_title->getValue();
		if ($context_title === false) {
			$context_title = "";
		}
		$context_ref_id = $this->filter_context_ref_id->getValue();
		if ($context_ref_id !== false) {
			$context_ref_id = intval($context_ref_id);
		} else {
			$context_ref_id = NULL;
		}
		/**
		 * @var ilDateTime $timestamp_start
		 */
		$timestamp_start = $this->filter_timestamp->getStart();
		if (is_object($timestamp_start) && !$timestamp_start->isNull()) {
			$timestamp_start = $timestamp_start->get(IL_CAL_UNIX);
		} else {
			$timestamp_start = NULL;
		}
		/**
		 * @var ilDateTime $timestamp_end
		 */
		$timestamp_end = $this->filter_timestamp->getEnd();
		if (is_object($timestamp_end) && !$timestamp_end->isNull()) {
			$timestamp_end = $timestamp_end->get(IL_CAL_UNIX);
		} else {
			$timestamp_end = NULL;
		}

		$this->setData(Log::getLogs($subject, $body, $from_email, $from_user_id, $from_firstname, $from_lastname, $to_email, $to_user_id, $to_firstname, $to_lastname, $context_title, $context_ref_id, $timestamp_start, $timestamp_end));
	}


	/**
	 * @return array
	 */
	public function getSelectableColumns(): array {
		$columns = [
			"subject" => "subject",
			"body" => "body",
			"from_email" => "from_email",
			"from_firstname" => "from_firstname",
			"from_lastname" => "from_lastname",
			"from_user_id" => "from_user_id",
			"to_email" => "to_email",
			"to_firstname" => "to_firstname",
			"to_lastname" => "to_lastname",
			"to_user_id" => "to_user_id",
			"context_title" => "context_title",
			"context_ref_id" => "context_ref_id",
			"timestamp" => "timestamp"
		];
		$columns = array_map(function (string $key): array {
			return [
				"id" => $key,
				"txt" => self::plugin()->translate($key, MailLoggerLogGUI::LANG_MODULE_LOG),
				"default" => true,
				"sort" => true
			];
		}, $columns);

		return $columns;
	}


	/**
	 *
	 */
	protected function initColumns()/*: void*/ {
		foreach ($this->getSelectableColumns() as $column) {
			if ($this->isColumnSelected($column["id"])) {
				$this->addColumn($column["txt"], ($column["sort"] ? $column["id"] : NULL));
			}
		}

		$this->addColumn(self::plugin()->translate("actions", MailLoggerLogGUI::LANG_MODULE_LOG));
	}


	/**
	 *
	 */
	protected function initExport()/*: void*/ {
		$this->setExportFormats([ self::EXPORT_CSV, self::EXPORT_EXCEL ]);
	}


	/**
	 * @param string $column
	 * @param array  $course
	 * @param bool   $raw_export
	 *
	 * @return string
	 */
	protected function getColumnValue(string $column, array $course, bool $raw_export = false): string {
		switch ($column) {
			case "timestamp":
				if ($raw_export) {
					$column = $course[$column];
				} else {
					$column = ilDatePresentation::formatDate(new ilDateTime($course[$column], IL_CAL_UNIX));
				}
				break;

			default:
				$column = $course[$column];
				break;
		}

		if (!empty($column)) {
			return $column;
		} else {
			return "";
		}
	}


	/**
	 * @param array $course
	 */
	protected function fillRow(/*array*/
		$course)/*: void*/ {
		$this->tpl->setCurrentBlock("column");

		foreach ($this->getSelectableColumns() as $column) {
			if ($this->isColumnSelected($column["id"])) {
				$column = $this->getColumnValue($column["id"], $course);

				if (!empty($column)) {
					$this->tpl->setVariable("COLUMN", $column);
				} else {
					$this->tpl->setVariable("COLUMN", " ");
				}

				$this->tpl->parseCurrentBlock();
			}
		}

		$actions = new ilAdvancedSelectionListGUI();
		$actions->setListTitle(self::plugin()->translate("actions", MailLoggerLogGUI::LANG_MODULE_LOG));
		$actions->addItem(self::plugin()->translate("log_action_show", MailLoggerLogGUI::LANG_MODULE_LOG),'show',self::dic()->ctrl()->getLinkTargetByClass(['ilUIPluginRouterGUI','MailLoggerLogGUI']),'show');
		$this->tpl->setVariable("COLUMN", $actions->getHTML());
		$this->tpl->parseCurrentBlock();
	}


	/**
	 * @param ilCSVWriter $csv
	 */
	protected function fillHeaderCSV(/*ilCSVWriter*/
		$csv)/*: void*/ {
		foreach ($this->getSelectableColumns() as $column) {
			$csv->addColumn($column["txt"]);
		}

		$csv->addRow();
	}


	/**
	 * @param ilCSVWriter $csv
	 * @param array       $course
	 */
	protected function fillRowCSV(/*ilCSVWriter*/
		$csv, /*array*/
		$course)/*: void*/ {
		foreach ($this->getSelectableColumns() as $column) {
			if ($this->isColumnSelected($column["id"])) {
				$csv->addColumn($this->getColumnValue($column["id"], $course, true));
			}
		}

		$csv->addRow();
	}


	/**
	 * @param ilExcel $excel
	 * @param int     $row
	 */
	protected function fillHeaderExcel(ilExcel $excel, /*int*/
		&$row)/*: void*/ {
		$col = 0;

		foreach ($this->getSelectableColumns() as $column) {
			$excel->setCell($row, $col, $column["txt"]);
			$col ++;
		}

		$excel->setBold("A" . $row . ":" . $excel->getColumnCoord($col - 1) . $row);
	}


	/**
	 * @param ilExcel $excel
	 * @param int     $row
	 * @param array   $course
	 */
	protected function fillRowExcel(ilExcel $excel, /*int*/
		&$row, /*array*/
		$course)/*: void*/ {
		$col = 0;
		foreach ($this->getSelectableColumns() as $column) {
			if ($this->isColumnSelected($column["id"])) {
				$excel->setCell($row, $col, $this->getColumnValue($column["id"], $course));
				$col ++;
			}
		}
	}
}
