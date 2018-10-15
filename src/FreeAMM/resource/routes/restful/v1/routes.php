<?php
$localRoutes = [
    /**
     * Status d'une application
     */
    'freeamm.app.get-status' => [
        'method'     => \FreeFW\Router\Route::METHOD_GET,
        'url'        => '/v1/application/:cli_code/:app_code',
        'controller' => 'FreeAMM::Controller::Application',
        'function'   => 'getStatus',
        'secured'    => false,
        'middleware' => []
    ],
    /**
     * Envoi du status d'un job
     */
    'freeamm.job.set-status' => [
        'method'     => \FreeFW\Router\Route::METHOD_POST,
        'url'        => '/v1/incoming_job',
        'controller' => 'FreeAMM::Controller::Application',
        'function'   => 'createOne',
        'secured'    => false,
        'middleware' => []
    ]
];
return $localRoutes;
