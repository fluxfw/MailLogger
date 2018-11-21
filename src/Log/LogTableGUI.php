<?php

namespace srag\AVL\Plugins\MailLogger\Log;

use ilAdvancedSelectionListGUI;
use ilDatePresentation;
use ilDateTime;
use ilMailLoggerPlugin;
use ilTextInputGUI;
use MailLoggerLogGUI;
use srag\AVL\Plugins\MailLogger\Utils\MailLoggerTrait;
use srag\CustomInputGUIs\MailLogger\DateDurationInputGUI\DateDurationInputGUI;
use srag\CustomInputGUIs\MailLogger\PropertyFormGUI\PropertyFormGUI;
use srag\CustomInputGUIs\MailLogger\TableGUI\TableGUI;

/**
 * Class LogTableGUI
 *
 * @package srag\AVL\Plugins\MailLogger\Log
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class LogTableGUI extends TableGUI {

	use MailLoggerTrait;
	const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
	const LANG_MODULE = MailLoggerLogGUI::LANG_MODULE_LOG;


	/**
	 * @inheritdoc
	 */
	protected function getColumnValue(/*string*/
		$column, /*array*/
		$row, /*bool*/
		$raw_export = false): string {
		switch ($column) {
			case "timestamp":
				if ($raw_export) {
					$column = $row[$column];
				} else {
					$column = ilDatePresentation::formatDate(new ilDateTime($row[$column], IL_CAL_UNIX));
				}
				break;

			default:
				$column = $row[$column];
				break;
		}

		if (!empty($column)) {
			return $column;
		} else {
			return "";
		}
	}


	/**
	 * @inheritdoc
	 */
	public function getSelectableColumns(): array {
		$columns = [
			"subject" => "subject",
			"from_email" => "from_email",
			"from_firstname" => "from_firstname",
			"from_lastname" => "from_lastname",
			"from_user_id" => "from_user_id",
			"to_email" => "to_email",
			"to_firstname" => "to_firstname",
			"to_lastname" => "to_lastname",
			"to_user_id" => "to_user_id",
			/*"context_title" => "context_title",
			"context_ref_id" => "context_ref_id",*/
			"timestamp" => "timestamp"
		];
		$default = [
			"subject",
			"from_email",
			"to_email",
			//"context_title",
			"timestamp"
		];

		$columns = array_map(function (string $key) use (&$default): array {
			return [
				"id" => $key,
				"default" => in_array($key, $default),
				"sort" => true
			];
		}, $columns);

		return $columns;
	}


	/**
	 * @inheritdoc
	 */
	protected function initColumns()/*: void*/ {
		parent::initColumns();

		$this->addColumn(self::plugin()->translate("actions", self::LANG_MODULE));

		$this->setDefaultOrderField("timestamp");
		$this->setDefaultOrderDirection("desc");
	}


	/**
	 * @inheritdoc
	 */
	protected function initData()/*: void*/ {
		$filter = $this->getFilterValues();

		$subject = $filter["subject"];
		$body = $filter["body"];
		$from_email = $filter["from_email"];
		$from_firstname = $filter["from_firstname"];
		$from_lastname = $filter["from_lastname"];
		$to_email = $filter["to_email"];
		$to_firstname = $filter["to_firstname"];
		$to_lastname = $filter["to_lastname"];
		/*$context_title = $this->filter_context_title->getValue();
		$context_ref_id = $this->filter_context_ref_id->getValue();
		if (!empty($context_ref_id)) {
			$context_ref_id = intval($context_ref_id);
		} else {
			$context_ref_id = NULL;
		}*/
		$context_title = "";
		$context_ref_id = NULL;
		/**
		 * @var ilDateTime $timestamp_start
		 */
		$timestamp_start = $filter["timestamp_start"];
		if (is_object($timestamp_start) && !$timestamp_start->isNull()) {
			$timestamp_start = $timestamp_start->get(IL_CAL_UNIX);
		} else {
			$timestamp_start = NULL;
		}
		/**
		 * @var ilDateTime $timestamp_end
		 */
		$timestamp_end = $filter["timestamp_end"];
		if (is_object($timestamp_end) && !$timestamp_end->isNull()) {
			$timestamp_end = $timestamp_end->get(IL_CAL_UNIX);
		} else {
			$timestamp_end = NULL;
		}

		$this->setData(self::logs()
			->getLogs($subject, $body, $from_email, $from_firstname, $from_lastname, $to_email, $to_firstname, $to_lastname, $context_title, $context_ref_id, $timestamp_start, $timestamp_end));
	}


	/**
	 * @inheritdoc
	 */
	protected function initExport()/*: void*/ {
		$this->setExportFormats([ self::EXPORT_CSV, self::EXPORT_EXCEL ]);
	}


	/**
	 * @inheritdoc
	 */
	public function initFilterFields()/*: void*/ {
		self::dic()->language()->loadLanguageModule("form");

		$this->filter_fields = [
			"subject" => [
				PropertyFormGUI::PROPERTY_CLASS => ilTextInputGUI::class
			],
			"body" => [
				PropertyFormGUI::PROPERTY_CLASS => ilTextInputGUI::class
			],
			"from_email" => [
				PropertyFormGUI::PROPERTY_CLASS => ilTextInputGUI::class
			],
			"from_firstname" => [
				PropertyFormGUI::PROPERTY_CLASS => ilTextInputGUI::class
			],
			"from_lastname" => [
				PropertyFormGUI::PROPERTY_CLASS => ilTextInputGUI::class
			],
			"to_email" => [
				PropertyFormGUI::PROPERTY_CLASS => ilTextInputGUI::class
			],
			"to_firstname" => [
				PropertyFormGUI::PROPERTY_CLASS => ilTextInputGUI::class
			],
			"to_lastname" => [
				PropertyFormGUI::PROPERTY_CLASS => ilTextInputGUI::class
			],
			/*"context_title" => [
				PropertyFormGUI::PROPERTY_CLASS => ilTextInputGUI::class
			],
			"context_ref_id" => [
				PropertyFormGUI::PROPERTY_CLASS => NumberInputGUI::class,
				"setMinValue" => 0
			]*/
			"timestamp" => [
				PropertyFormGUI::PROPERTY_CLASS => DateDurationInputGUI::class,
				"setShowTime" => true
			]
		];
	}


	/**
	 * @inheritdoc
	 */
	protected function initId()/*: void*/ {
		$this->setId("maillogger_log");
	}


	/**
	 * @inheritdoc
	 */
	protected function initTitle()/*: void*/ {
		$this->setTitle(self::plugin()->translate("log", MailLoggerLogGUI::CMD_LOG));
	}


	/**
	 * @param array $row
	 */
	protected function fillRow(/*array*/
		$row)/*: void*/ {
		self::dic()->ctrl()->setParameter($this->parent_obj, "log_id", $row["id"]);

		parent::fillRow($row);

		$actions = new ilAdvancedSelectionListGUI();
		$actions->setListTitle(self::plugin()->translate("actions", self::LANG_MODULE));
		$actions->addItem(self::plugin()->translate("show_email", self::LANG_MODULE), "", self::dic()->ctrl()
			->getLinkTarget($this->parent_obj, MailLoggerLogGUI::CMD_SHOW_EMAIL));
		$this->tpl->setVariable("COLUMN", $actions->getHTML());
		$this->tpl->parseCurrentBlock();

		self::dic()->ctrl()->setParameter($this->parent_obj, "log_id", NULL);
	}
}
