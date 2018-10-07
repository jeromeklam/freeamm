<?php
$vdir = getenv('COMPOSER_VENDOR_DIR');
define('APP_ROOT', dirname(__FILE__) . '/../');
define('APP_SRC', dirname(__FILE__) . '/../src');
define('APP_CACHE', dirname(__FILE__) . '/../cache');
define('APP_LOG', dirname(__FILE__) . '/../log');
if ($vdir == '') {
    define('APP_MOD', dirname(__FILE__) . '/../vendor/');
} else {
    define('APP_MOD', rtrim($vdir) . '/');
}
define('APP_NAME', 'FREEAMM');
define('API_SCHEMES', 'https');
define('API_HOST', 'freeamm.fr');

$startTs = microtime(true);

/**
 * Recherche du fichier de configuration associée au serveur (virtualHost)
 */
$server = 'freeamm-dev';
if (isset($_SERVER['SERVER_NAME'])) {
    $server = $_SERVER['SERVER_NAME'];
}

/**
 * Fichier de configuration
 */
if (is_file(APP_ROOT . '/config/' . strtolower($server) . '.ini.php')) {
    require_once APP_ROOT . '/config/' . strtolower($server) . '.ini.php';
} else {
    $server = gethostname();
    if (is_file(APP_ROOT . '/config/' . strtolower($server) . '.ini.php')) {
        require_once APP_ROOT . '/config/' . strtolower($server) . '.ini.php';
    } else {
        require_once APP_ROOT . '/config/ini.php';
    }
}

/**
 * Boot
 */
require_once APP_SRC . '/bootstrap.php';

/**
 * Go
 */
try {
    // Réponse aux "preflights", on sort direct.... c'est à gérer côté serveur web
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        header('HTTP/1.1 200 OK');
        exit(0);
    }
    // Si pas de "prefligths" : Config
    if (is_file(APP_ROOT . '/config/' . strtolower($server) . '.config.php')) {
        $myConfig = \FreeFW\Application\Config::load(APP_ROOT . '/config/' . strtolower($server) . '.config.php');
    } else {
        $myConfig = \FreeFW\Application\Config::load(APP_ROOT . '/config/config.php');
    }
    // Le logger
    $myLogCfg = $myConfig->get('logger');
    if (is_array($myLogCfg)) {
        if (array_key_exists('file', $myLogCfg)) {
            if (array_key_exists('level', $myLogCfg)) {
                $logFile  = $myLogCfg['file'];
                $myLogger = new \FreeFW\Log\FileLogger($logFile, $myLogCfg['level']);
            } else {
                throw new \InvalidArgumentException('Log level missing !');
            }
        } else {
            throw new \UnexpectedValueException('Log type is unknown !');
        }
    } else {
        $myLogger = new \Psr\Log\NullLogger();
    }
    // La connexion DB
    $myStgCfg = $myConfig->get('storage');
    if (is_array($myStgCfg)) {
        foreach ($myStgCfg as $key => $stoCfg) {
            $storage = \FreeFW\Storage\StorageFactory::getFactory(
                $stoCfg['dsn'],
                $stoCfg['user'],
                $stoCfg['paswd']
            );
            $storage->setLogger($myLogger);
            \FreeFW\DI\DI::setShared('Storage::' . $key, $storage);
        }
    } else {
        throw new \FreeFW\Core\FreeFWException('No storage configuration found !');
    }
    // Micro application
    $app = \FreeFW\Application\Application::getInstance($myConfig, $myLogger);
    // EventManager
    $myEvents = \FreeFW\Listener\EventManager::getInstance();
    $myEvents->bind(\FreeFW\Constants::EVENT_ROUTE_NOT_FOUND, function () {
        //@todo
        var_dump('404'); die;
    });
    $myEvents->bind(\FreeFW\Constants::EVENT_AFTER_RENDER, function () use ($app, $startTs) {
        $endTs = microtime(true);
        $diff  = $endTs - $startTs;
        $app->getLogger()->info('Total execution time : ' . $diff);
    });
    /**
     * FreeAmm DI
     */
    \FreeFW\DI\DI::registerDI('FreeFW', $myConfig, $myLogger);
    \FreeFW\DI\DI::registerDI('FreeAMM', $myConfig, $myLogger);
    \FreeFW\DI\DI::registerDI('FreeSSO', $myConfig, $myLogger);
    /**
     * On va chercher les routes des modules, ...
     */
    $freeAmmRoutes = \FreeAMM\Router\FreeFW::getRoutes();
    /**
     * GO...
     */
    $app
        ->setEventManager($myEvents)
        ->addRoutes($freeAmmRoutes)
    ;
    // GO
    $app->handle();
} catch (\Exception $ex) {
    var_dump($ex);
}
