<?php
namespace FreeAMM\Model;

/**
 * Incoming Job States
 *
 * @author jeromeklam
 */
class IncomingJobState extends  \FreeAMM\Model\Base\IncomingJobState implements
    \FreeFW\Interfaces\ValidatorInterface
{

    /**
     * Status
     * @var string
     */
    const STATUS_PENDING = 'PENDING';

    /**
     * States
     * @var string
     */
    const STATE_OK    = 'OK';
    const STATE_ERROR = 'ERROR';

    /**
     * Behaviour
     */
    use \FreeFW\Behaviour\ValidatorTrait;

    /**
     * Validate model
     *
     * @return void
     */
    protected function validate()
    {
    }

    /**
     *
     * {@inheritDoc}
     * @see \FreeFW\Core\Model::init()
     */
    public function init()
    {
        $this->ijs_id     = 0;
        $this->ijs_state  = self::STATE_OK;
        $this->ijs_status = self::STATUS_PENDING;
    }
}