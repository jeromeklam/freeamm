<?php
namespace FreeAMM\Model\Base;

/**
 * Client
 *
 * @author jeromeklam
 */
abstract class Client extends \FreeAMM\Model\StorageModel\Client
{
    protected $cli_id = 0;
    protected $cli_code = null;
    protected $cli_name = null;
}
