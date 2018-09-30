<?php
namespace FreeAMM\Controller;

/**
 * Application controller
 *
 * @author jeromeklam
 */
class Application extends \FreeFW\Core\Controller
{

    /**
     * Get application status
     *
     * @param \Psr\Http\Message\ServerRequestInterface $p_request
     */
    public function getStatus(\Psr\Http\Message\ServerRequestInterface $p_request)
    {
        $this->logger->debug('FreeAMM.Controller.Service.getStatus.start');
        $crmCode = $p_request->getAttribute('crm_code', false);
        $appCode = $p_request->getAttribute('app_code', false);
        if ($crmCode !== false && $appCode !== false) {
            $AppService = \FreeFW\DI\DI::get('FreeAMM::Service::Application');
            $AppService->getClientApplication($crmCode, $appCode);
        } else {
            // Oups, wrong parameters...
        }
        $this->logger->debug('FreeAMM.Controller.Service.getStatus.end');
    }

    /**
     * Add now job status
     *
     * @param \Psr\Http\Message\ServerRequestInterface $p_request
     */
    public function setJobStatus(\Psr\Http\Message\ServerRequestInterface $p_request)
    {
        $this->logger->debug('FreeAMM.Controller.Service.getStatus.start');
        $crmCode = $p_request->getAttribute('crm_code', false);
        $appCode = $p_request->getAttribute('app_code', false);
        $jobCode = $p_request->getAttribute('job_code', false);
        if ($crmCode !== false && $appCode !== false) {
            $AppService = \FreeFW\DI\DI::get('FreeAMM::Service::Application');
            $AppService->addJobState($crmCode, $appCode, $jobCode);
        } else {
            // Oups, wrong parameters...
        }
        $this->logger->debug('FreeAMM.Controller.Service.getStatus.end');
    }
}
