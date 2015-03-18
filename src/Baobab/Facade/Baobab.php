<?php

namespace Baobab\Facade;

use Baobab\Configuration\Configuration;
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

    /** @var ClassLoader */
    private static $classLoader = null;

    /** @var Configuration */
    private static $configuration = null;

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
     * @return ClassLoader
     */
    public static function classLoader()
    {
        return self::$classLoader;
    }

    /**
     * @param Blade $blade
     */
    public static function setBlade($blade)
    {
        self::$blade = $blade;
    }

    /**
     * @param ClassLoader $classLoader
     */
    public static function setClassLoader($classLoader)
    {
        self::$classLoader = $classLoader;
    }

    /**
     * @param Configuration $configuration
     */
    public static function setConfiguration($configuration)
    {
        self::$configuration = $configuration;
    }


}