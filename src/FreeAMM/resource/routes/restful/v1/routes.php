<?php
$localRoutes = [
    /**
     * Status d'une application
     */
    'freeamm.app.get-status' => [
        'method'     => \FreeFW\Router\Route::METHOD_GET,
        'url'        => '/v1/incoming_job',
        'controller' => 'FreeAMM::Controller::Application',
        'function'   => 'getAll',
        'auth'       => \FreeFW\Router\Route::AUTH_NONE,
        'middleware' => [],
        'model'      => 'FreeAMM::Model::IncomingJobState',
        'results' => [
            '200' => [
                'type'  => \FreeFW\Router\Route::RESULT_LIST,
                'model' => 'FreeAMM::Model::IncomingJobState'
            ]
        ]
    ],
    /**
     * Envoi du status d'un job
     */
    'freeamm.job.set-status' => [
        'method'     => \FreeFW\Router\Route::METHOD_POST,
        'url'        => '/v1/incoming_job',
        'controller' => 'FreeAMM::Controller::Application',
        'function'   => 'createOne',
        'auth'       => \FreeFW\Router\Route::AUTH_NONE,
        'middleware' => []
    ]
];
return $localRoutes;
