<?php
namespace FreeAMM\Model\Base;

/**
 * Incoming Job States
 *
 * @author jeromeklam
 */
abstract class IncomingJobState extends \FreeAMM\Model\StorageModel\IncomingJobState
{
    protected $ijs_id = 0;
    protected $ijs_crm = null;
    protected $ijs_app = null;
    protected $ijs_job = null;
    protected $ijs_state = null;
    protected $ijs_ts = null;
    protected $ijs_status = null;
    protected $ijs_comments = null;
}