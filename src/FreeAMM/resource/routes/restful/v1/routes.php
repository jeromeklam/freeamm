<?php
$localRoutes = [
    /**
     * Status d'une application
     */
    'freeamm.app.get-status' => [
        'method'     => \FreeFW\Router\Route::METHOD_GET,
        'url'        => '/v1/application/:crm_code/:app_code',
        'controller' => 'FreeAMM::Controller::Application',
        'function'   => 'getStatus'
    ],
    /**
     * Envoi du status d'un job
     */
    'freeamm.job.set-status' => [
        'method'     => \FreeFW\Router\Route::METHOD_POST,
        'url'        => '/v1/job/:crm_code/:app_code/:job_code',
        'controller' => 'FreeAMM::Controller::Application',
        'function'   => 'setJobStatus'
    ]
];
return $localRoutes;