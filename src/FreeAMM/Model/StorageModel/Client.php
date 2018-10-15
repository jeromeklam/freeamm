<?php
namespace FreeAMM\Model\StorageModel;

use \FreeFW\Constants as FFCST;

/**
 * Client
 *
 * @author jeromeklam
 */
abstract class Client extends \FreeFW\Core\StorageModel
{

    /**
     * Field properties as static arrays
     * @var array
     */
    protected static $PRP_CLI_ID = [
        FFCST::PROPERTY_PRIVATE => 'cli_id',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_BIGINT,
        FFCST::PROPERTY_OPTIONS => [FFCST::OPTION_PK]
    ];
    protected static $PRP_CLI_CODE = [
        FFCST::PROPERTY_PRIVATE => 'cli_code',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_STRING,
        FFCST::PROPERTY_OPTIONS => [FFCST::OPTION_REQUIRED]
    ];
    protected static $PRP_CLI_NAME = [
        FFCST::PROPERTY_PRIVATE => 'cli_name',
        FFCST::PROPERTY_TYPE    => FFCST::TYPE_STRING
    ];

    /**
     * get properties
     *
     * @return array[]
     */
    public static function getProperties()
    {
        return [
            'cli_id'   => self::$PRP_CLI_ID,
            'cli_code' => self::$PRP_CLI_CODE,
            'cli_name' => self::$PRP_CLI_NAME
        ];
    }

    /**
     * Set object source
     *
     * @return string
     */
    public static function getSource()
    {
        return 'crm_client';
    }
}
