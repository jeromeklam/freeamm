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
        'destination' => 'cli_id',
        'type'        => FFCST::TYPE_BIGINT,
        'options'     => [FFCST::OPTION_PK]
    ];
    protected static $PRP_CLI_CODE = [
        'destination' => 'cli_code',
        'type'        => FFCST::TYPE_STRING,
        'options'     => [FFCST::OPTION_REQUIRED]
    ];
    protected static $PRP_CLI_NAME = [
        'destination' => 'cli_name',
        'type'        => FFCST::TYPE_STRING
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
