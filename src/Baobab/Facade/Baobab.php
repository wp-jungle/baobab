<?php

namespace Baobab\Facade;

use Baobab\Ajax\Ajax;
use Baobab\Configuration\Configuration;
use Baobab\Loader\ObjectRegistry;
use Composer\Autoload\ClassLoader;
use Philo\Blade\Blade;

/**
 * Class Baobab
 * @package Baobab\Facade
 *
 *          A facade to give access to some components in Baobab. Not as clean as it could be but it's a start
 */
class Baobab
{
    /** @var Blade */
    private static $blade = null;

    /** @var ObjectRegistry */
    private static $objectRegistry = null;

    /** @var Configuration */
    private static $configuration = null;

    /** @var Ajax */
    private static $ajax = null;

    /**
     * @return Configuration
     */
    public static function configuration()
    {
        return self::$configuration;
    }

    /**
     * @return Blade
     */
    public static function blade()
    {
        return self::$blade;
    }

    /**
     * @return Ajax
     */
    public static function ajax()
    {
        return self::$ajax;
    }

    /**
     * @return ObjectRegistry
     */
    public static function objectRegistry()
    {
        return self::$objectRegistry;
    }

    /**
     * @param Blade $blade
     */
    public static function setBlade($blade)
    {
        self::$blade = $blade;
    }

    /**
     * @param ObjectRegistry $objectRegistry
     */
    public static function setObjectRegistry($objectRegistry)
    {
        self::$objectRegistry = $objectRegistry;
    }

    /**
     * @param Configuration $configuration
     */
    public static function setConfiguration($configuration)
    {
        self::$configuration = $configuration;
    }

    /**
     * @param Ajax $ajax
     */
    public static function setAjax($ajax)
    {
        self::$ajax = $ajax;
    }
}