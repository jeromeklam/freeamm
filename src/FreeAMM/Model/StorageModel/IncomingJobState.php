<?php
namespace FreeAMM\Model\StorageModel;

use \FreeFW\Constants as FFCST;

/**
 * Incoming Job States
 *
 * @author jeromeklam
 */
abstract class IncomingJobState extends \FreeFW\Core\StorageModel
{

    /**
     * Field properties as static arrays
     * @var array
     */
    protected static $PRP_IJS_ID = [
        FFCST::PROPERTY_PRIVATE => 'ijs_id',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_BIGINT,
        FFCST::PROPERTY_OPTIONS => [FFCST::OPTION_PK]
    ];
    protected static $PRP_IJS_CLI = [
        FFCST::PROPERTY_PRIVATE => 'ijs_cli',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_SELECT
    ];
    protected static $PRP_IJS_APP = [
        FFCST::PROPERTY_PRIVATE => 'ijs_app',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_SELECT,
        FFCST::PROPERTY_OPTIONS => [FFCST::OPTION_REQUIRED]
    ];
    protected static $PRP_IJS_JOB = [
        FFCST::PROPERTY_PRIVATE => 'ijs_job',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_SELECT
    ];
    protected static $PRP_IJS_VM = [
        FFCST::PROPERTY_PRIVATE => 'ijs_vm',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_SELECT
    ];
    protected static $PRP_IJS_STATE = [
        FFCST::PROPERTY_PRIVATE => 'ijs_state',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_LIST,
        FFCST::PROPERTY_OPTIONS => [FFCST::OPTION_REQUIRED]
    ];
    protected static $PRP_IJS_TS = [
        FFCST::PROPERTY_PRIVATE => 'ijs_ts',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_DATETIME,
        FFCST::PROPERTY_OPTIONS => [FFCST::OPTION_REQUIRED]
    ];
    protected static $PRP_IJS_STATUS = [
        FFCST::PROPERTY_PRIVATE => 'ijs_status',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_LIST,
        FFCST::PROPERTY_OPTIONS => [FFCST::OPTION_REQUIRED]
    ];
    protected static $PRP_IJS_COMMENTS = [
        FFCST::PROPERTY_PRIVATE => 'ijs_comments',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_TEXT
    ];

    /**
     * get properties
     *
     * @return array[]
     */
    public static function getProperties()
    {
        return [
            'ijs_id'       => self::$PRP_IJS_ID,
            'ijs_cli'      => self::$PRP_IJS_CLI,
            'ijs_app'      => self::$PRP_IJS_APP,
            'ijs_job'      => self::$PRP_IJS_JOB,
            'ijs_vm'       => self::$PRP_IJS_VM,
            'ijs_state'    => self::$PRP_IJS_STATE,
            'ijs_ts'       => self::$PRP_IJS_TS,
            'ijs_status'   => self::$PRP_IJS_STATUS,
            'ijs_comments' => self::$PRP_IJS_COMMENTS
        ];
    }

    /**
     * Set object source
     *
     * @return string
     */
    public static function getSource()
    {
        return 'tech_incoming_job_state';
    }
}
