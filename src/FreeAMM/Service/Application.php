<?php
namespace FreeAMM\Service;

/**
 * Service application
 *
 * @author jeromeklam
 */
class Application extends \FreeFW\Core\Service
{

    /**
     * Return last application installation for a client
     *
     * @param string $p_crm_code
     * @param string $p_app_code
     */
    public function getClientApplication(string $p_crm_code, string $p_app_code)
    {
        $this->logger->debug('FreeAMM.Service.Application.getClientApplication.start');
        $ijsModel = \FreeFW\DI\DI::get('FreeAMM::Model::IncomingJobState');
        $ijsModel
            ->setIjsCrm($p_crm_code)
            ->setIjsApp($p_app_code)
        ;
        if (!$ijsModel->create()) {
            var_export($ijsModel->getErrors());
        }
        $this->logger->debug('FreeAMM.Service.Application.getClientApplication.end');
    }

    /**
     * Add new job state
     *
     * @param string $p_crm_code
     * @param string $p_app_code
     * @param string $p_job_code
     */
    public function addJobState(string $p_crm_code, string $p_app_code, string $p_job_code)
    {
        $this->logger->debug('FreeAMM.Service.Application.addJobState.start');
        $ijsModel = \FreeFW\DI\DI::get('FreeAMM::Model::IncomingJobState');
        $ijsModel
            ->setIjsCrm($p_crm_code)
            ->setIjsApp($p_app_code)
            ->setIjsJob($p_job_code)
        ;
        if (!$ijsModel->create()) {
            var_export($ijsModel->getErrors());
        }
        $this->logger->debug('FreeAMM.Service.Application.addJobState.end');
    }
}
