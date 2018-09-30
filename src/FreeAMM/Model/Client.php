<?php
namespace FreeAMM\Model;

/**
 * Client
 *
 * @author jeromeklam
 */
class Client extends \FreeAMM\Model\Base\Client implements
    \FreeFW\Interfaces\ValidatorInterface
{

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
        $this->cli_id = 0;
    }
}
