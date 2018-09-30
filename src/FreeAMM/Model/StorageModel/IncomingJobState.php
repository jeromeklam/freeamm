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
        'destination' => 'ijs_id',
        'type'        => FFCST::TYPE_BIGINT,
        'options'     => [FFCST::OPTION_PK]
    ];
    protected static $PRP_IJS_CLI = [
        'destination' => 'ijs_cli',
        'type'        => FFCST::TYPE_SELECT,
        'options'     => [FFCST::OPTION_REQUIRED]
    ];
    protected static $PRP_IJS_APP = [
        'destination' => 'ijs_app',
        'type'        => FFCST::TYPE_SELECT,
        'options'     => [FFCST::OPTION_REQUIRED]
    ];
    protected static $PRP_IJS_JOB = [
        'destination' => 'ijs_job',
        'type'        => FFCST::TYPE_SELECT,
        'options'     => [FFCST::OPTION_REQUIRED]
    ];
    protected static $PRP_IJS_STATE = [
        'destination' => 'ijs_state',
        'type'        => FFCST::TYPE_LIST,
        'options'     => [FFCST::OPTION_REQUIRED]
    ];
    protected static $PRP_IJS_TS = [
        'destination' => 'ijs_ts',
        'type'        => FFCST::TYPE_DATETIME,
        'options'     => [FFCST::OPTION_REQUIRED]
    ];
    protected static $PRP_IJS_STATUS = [
        'destination' => 'ijs_status',
        'type'        => FFCST::TYPE_LIST,
        'options'     => [FFCST::OPTION_REQUIRED]
    ];
    protected static $PRP_IJS_COMMENTS = [
        'destination' => 'ijs_comments',
        'type'        => FFCST::TYPE_TEXT
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
        return 'tech_incomingjobstate';
    }
}
