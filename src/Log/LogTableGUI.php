<?php

namespace srag\AVL\Plugins\MailLogger\Log;

use ilAdvancedSelectionListGUI;
use ilCSVWriter;
use ilExcel;
use ilMailLoggerPlugin;
use ilTable2GUI;
use MailLoggerLogGUI;
use srag\AVL\Plugins\MailLogger\Log\Log;
use srag\AVL\Plugins\MailLogger\Utils\MailLoggerTrait;
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
	 * LogTableGUI constructor
	 *
	 * @param MailLoggerLogGUI $parent
	 * @param string                $parent_cmd
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

	}


	/**
	 *
	 */
	protected function initData()/*: void*/ {
		$this->setData(Log::getArray());
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
