<?php

namespace srag\Plugins\MailLogger\Log;

use ActiveRecord;
use arConnector;
use ilDateTime;
use ilMailLoggerPlugin;
use srag\DIC\MailLogger\DICTrait;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class Log
 *
 * @package srag\Plugins\MailLogger\Log
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Log extends ActiveRecord
{

    use DICTrait;
    use MailLoggerTrait;

    const TABLE_NAME = ilMailLoggerPlugin::PLUGIN_ID . "_log";
    const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;


    /**
     * @inheritDoc
     */
    public function getConnectorContainerName() : string
    {
        return self::TABLE_NAME;
    }


    /**
     * @inheritDoc
     *
     * @deprecated
     */
    public static function returnDbTableName() : string
    {
        return self::TABLE_NAME;
    }


    /**
     * @var int
     *
     * @con_has_field   true
     * @con_fieldtype   integer
     * @con_length      8
     * @con_is_notnull  true
     * @con_is_primary  true
     * @con_sequence    true
     */
    protected $id;
    /**
     * @var string
     *
     * @con_has_field   true
     * @con_fieldtype   text
     * @con_is_notnull  true
     */
    protected $subject = "";
    /**
     * @var string
     *
     * @con_has_field   true
     * @con_fieldtype   text
     * @con_is_notnull  true
     */
    protected $body = "";
    /**
     * @var bool
     *
     * @con_has_field   true
     * @con_fieldtype   integer
     * @con_length      1
     * @con_is_notnull  true
     */
    protected $is_system = false;
    /**
     * @var string
     *
     * @con_has_field   true
     * @con_fieldtype   text
     * @con_is_notnull  true
     */
    protected $from_email = "";
    /**
     * @var string
     *
     * @con_has_field   true
     * @con_fieldtype   text
     * @con_is_notnull  true
     */
    protected $from_firstname = "";
    /**
     * @var string
     *
     * @con_has_field   true
     * @con_fieldtype   text
     * @con_is_notnull  true
     */
    protected $from_lastname = "";
    /**
     * @var int
     *
     * @con_has_field   true
     * @con_fieldtype   integer
     * @con_length      8
     * @con_is_notnull  true
     */
    protected $from_user_id;
    /**
     * @var string
     *
     * @con_has_field   true
     * @con_fieldtype   text
     * @con_is_notnull  true
     */
    protected $to_email = "";
    /**
     * @var string
     *
     * @con_has_field   true
     * @con_fieldtype   text
     * @con_is_notnull  true
     */
    protected $to_firstname = "";
    /**
     * @var string
     *
     * @con_has_field   true
     * @con_fieldtype   text
     * @con_is_notnull  true
     */
    protected $to_lastname = "";
    /**
     * @var int
     *
     * @con_has_field   true
     * @con_fieldtype   integer
     * @con_length      8
     * @con_is_notnull  true
     */
    protected $to_user_id;
    /**
     * @var string|null
     *
     * @con_has_field   true
     * @con_fieldtype   text
     * @con_is_notnull  false
     */
    protected $context_title = null;
    /**
     * @var int|null
     *
     * @con_has_field   true
     * @con_fieldtype   integer
     * @con_length      8
     * @con_is_notnull  false
     */
    protected $context_ref_id = null;
    /**
     * @var int
     *
     * @con_has_field   true
     * @con_fieldtype   timestamp
     * @con_is_notnull  true
     */
    protected $timestamp;


    /**
     * Log constructor
     *
     * @param int              $primary_key_value
     * @param arConnector|null $connector
     */
    public function __construct(/*int*/ $primary_key_value = 0, /*?*/ arConnector $connector = null)
    {
        parent::__construct($primary_key_value, $connector);
    }


    /**
     * @inheritDoc
     */
    public function sleep(/*string*/ $field_name)
    {
        $field_value = $this->{$field_name};

        switch ($field_name) {
            case "is_system":
                return ($field_value ? 1 : 0);

            case "timestamp":
                return (new ilDateTime($field_value, IL_CAL_UNIX))->get(IL_CAL_DATETIME);

            default:
                return null;
        }
    }


    /**
     * @inheritDoc
     */
    public function wakeUp(/*string*/ $field_name, $field_value)
    {
        switch ($field_name) {
            case "id":
            case "from_type":
            case "from_user_id":
            case "to_user_id":
                return intval($field_value);

            case "is_system":
                return boolval($field_value);

            case "context_ref_id":
                if ($field_value !== null) {
                    return intval($field_value);
                } else {
                    return null;
                }

            case "timestamp":
                return intval((new ilDateTime($field_value, IL_CAL_DATETIME))->getUnixTime());

            default:
                return null;
        }
    }


    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }


    /**
     * @param int $id
     */
    public function setId(int $id)/*: void*/
    {
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getSubject() : string
    {
        return $this->subject;
    }


    /**
     * @param string $subject
     */
    public function setSubject(string $subject)/*: void*/
    {
        $this->subject = $subject;
    }


    /**
     * @return string
     */
    public function getBody() : string
    {
        return $this->body;
    }


    /**
     * @param string $body
     */
    public function setBody(string $body)/*: void*/
    {
        $this->body = $body;
    }


    /**
     * @return bool
     */
    public function isSystem() : bool
    {
        return $this->is_system;
    }


    /**
     * @param bool $is_system
     */
    public function setIsSystem(bool $is_system)/*: void*/
    {
        $this->is_system = $is_system;
    }


    /**
     * @return string
     */
    public function getFromEmail() : string
    {
        return $this->from_email;
    }


    /**
     * @param string $from_email
     */
    public function setFromEmail(string $from_email)/*: void*/
    {
        $this->from_email = $from_email;
    }


    /**
     * @return string
     */
    public function getFromFirstname() : string
    {
        return $this->from_firstname;
    }


    /**
     * @param string $from_firstname
     */
    public function setFromFirstname(string $from_firstname)/*: void*/
    {
        $this->from_firstname = $from_firstname;
    }


    /**
     * @return string
     */
    public function getFromLastname() : string
    {
        return $this->from_lastname;
    }


    /**
     * @param string $from_lastname
     */
    public function setFromLastname(string $from_lastname)/*: void*/
    {
        $this->from_lastname = $from_lastname;
    }


    /**
     * @return int
     */
    public function getFromUserId() : int
    {
        return $this->from_user_id;
    }


    /**
     * @param int $from_user_id
     */
    public function setFromUserId(int $from_user_id)/*: void*/
    {
        $this->from_user_id = $from_user_id;
    }


    /**
     * @return string
     */
    public function getToEmail() : string
    {
        return $this->to_email;
    }


    /**
     * @param string $to_email
     */
    public function setToEmail(string $to_email)/*: void*/
    {
        $this->to_email = $to_email;
    }


    /**
     * @return string
     */
    public function getToFirstname() : string
    {
        return $this->to_firstname;
    }


    /**
     * @param string $to_firstname
     */
    public function setToFirstname(string $to_firstname)/*: void*/
    {
        $this->to_firstname = $to_firstname;
    }


    /**
     * @return string
     */
    public function getToLastname() : string
    {
        return $this->to_lastname;
    }


    /**
     * @param string $to_lastname
     */
    public function setToLastname(string $to_lastname)/*: void*/
    {
        $this->to_lastname = $to_lastname;
    }


    /**
     * @return int
     */
    public function getToUserId() : int
    {
        return $this->to_user_id;
    }


    /**
     * @param int $to_user_id
     */
    public function setToUserId(int $to_user_id)/*: void*/
    {
        $this->to_user_id = $to_user_id;
    }


    /**
     * @return string|null
     */
    public function getContextTitle()/*?: string*/
    {
        return $this->context_title;
    }


    /**
     * @param string|null $context_title
     */
    public function setContextTitle(/*?string*/ $context_title)/*: void*/
    {
        $this->context_title = $context_title;
    }


    /**
     * @return int|null
     */
    public function getContextRefId()/*: ?int*/
    {
        return $this->context_ref_id;
    }


    /**
     * @param int|null $context_ref_id
     */
    public function setContextRefId(/*?int*/ $context_ref_id)/*: void*/
    {
        $this->context_ref_id = $context_ref_id;
    }


    /**
     * @return int
     */
    public function getTimestamp() : int
    {
        return $this->timestamp;
    }


    /**
     * @param int $timestamp
     */
    public function setTimestamp(int $timestamp)/*: void*/
    {
        $this->timestamp = $timestamp;
    }
}
