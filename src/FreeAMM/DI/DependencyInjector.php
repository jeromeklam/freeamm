<?php
namespace FreeAMM\DI;

/**
 * Dependency injector
 *
 * @author jeromeklam
 */
class DependencyInjector extends \FreeFW\Core\DI implements \FreeFW\Interfaces\DependencyInjectorInterface
{

    /**
     * Instance
     * @var \FreeAMM\DI\DependencyInjector
     */
    protected static $instance = null;

    /**
     * Constructor
     */
    protected function __construct(
        \FreeFW\Application\Config $p_config,
        \Psr\Log\LoggerInterface $p_logger
    ) {
        $this->setConfig($p_config);
        $this->setLogger($p_logger);
    }

    /**
     * Get instance
     *
     * @return \FreeAMM\DI\DependencyInjector
     */
    public static function getInstance(
        \FreeFW\Application\Config $p_config,
        \Psr\Log\LoggerInterface $p_logger
    ) {
        if (self::$instance === null) {
            self::$instance = new static($p_config, $p_logger);
        }
        return self::$instance;
    }

    /**
     *
     * {@inheritDoc}
     * @see \FreeFW\Interfaces\DependencyInjectorInterface::getController()
     */
    public function getController($p_name)
    {
        $class_name = '\\FreeAMM\Controller\\' . \FreeFW\Tools\PBXString::toCamelCase($p_name, true);
        if (class_exists($class_name)) {
            $cls = new $class_name();
            if ($cls instanceof \Psr\Log\LoggerAwareInterface) {
                $cls->setLogger($this->logger);
            }
            if ($cls instanceof \FreeFW\Interfaces\ConfigAwareTraitInterface) {
                $cls->setConfig($this->config);
            }
            return $cls;
        }
        throw new \FreeFW\Core\FreeFWException(sprintf('Class %s not found !', $class_name));
    }

    /**
     *
     * {@inheritDoc}
     * @see \FreeFW\Interfaces\DependencyInjectorInterface::getService()
     */
    public function getService($p_name)
    {
        $class_name = '\\FreeAMM\Service\\' . \FreeFW\Tools\PBXString::toCamelCase($p_name, true);
        if (class_exists($class_name)) {
            $cls = new $class_name();
            if ($cls instanceof \Psr\Log\LoggerAwareInterface) {
                $cls->setLogger($this->logger);
            }
            if ($cls instanceof \FreeFW\Interfaces\ConfigAwareTraitInterface) {
                $cls->setConfig($this->config);
            }
            return $cls;
        }
        throw new \FreeFW\Core\FreeFWException(sprintf('Class %s not found !', $class_name));
    }

    /**
     *
     * {@inheritDoc}
     * @see \FreeFW\Interfaces\DependencyInjectorInterface::getModel()
     */
    public function getModel($p_name)
    {
        $class_name = '\\FreeAMM\Model\\' . \FreeFW\Tools\PBXString::toCamelCase($p_name, true);
        if (class_exists($class_name)) {
            $cls = new $class_name();
            $cls->init();
            if ($cls instanceof \Psr\Log\LoggerAwareInterface) {
                $cls->setLogger($this->logger);
            }
            if ($cls instanceof \FreeFW\Interfaces\StorageStrategyInterface) {
                $storage = \FreeFW\DI\DI::getShared('FreeAMM::Storage::default');
                $cls->setStrategy($storage);
            }
            if ($cls instanceof \FreeFW\Interfaces\ConfigAwareTraitInterface) {
                $cls->setConfig($this->config);
            }
            return $cls;
        }
        throw new \FreeFW\Core\FreeFWException(sprintf('Class %s not found !', $class_name));
    }

    /**
     *
     * {@inheritDoc}
     * @see \FreeFW\Interfaces\DependencyInjectorInterface::getManager()
     */
    public function getManager($p_name)
    {
        $class_name = '\\FreeAMM\Manager\\' . \FreeFW\Tools\PBXString::toCamelCase($p_name, true);
        if (class_exists($class_name)) {
            $cls = new $class_name();
            if ($cls instanceof \Psr\Log\LoggerAwareInterface) {
                $cls->setLogger($this->logger);
            }
            if ($cls instanceof \FreeFW\Interfaces\ConfigAwareTraitInterface) {
                $cls->setConfig($this->config);
            }
            return $cls;
        }
        throw new \FreeFW\Core\FreeFWException(sprintf('Class %s not found !', $class_name));
    }

    /**
     *
     * {@inheritDoc}
     * @see \FreeFW\Interfaces\DependencyInjectorInterface::getMiddleware()
     */
    public function getMiddleware($p_name)
    {
        $class_name = '\\FreeAMM\Middleware\\' . \FreeFW\Tools\PBXString::toCamelCase($p_name, true);
        if (class_exists($class_name)) {
            $cls = new $class_name();
            if ($cls instanceof \Psr\Log\LoggerAwareInterface) {
                $cls->setLogger($this->logger);
            }
            if ($cls instanceof \FreeFW\Interfaces\ConfigAwareTraitInterface) {
                $cls->setConfig($this->config);
            }
            return $cls;
        }
        throw new \FreeFW\Core\FreeFWException(sprintf('Class %s not found !', $class_name));
    }
}
