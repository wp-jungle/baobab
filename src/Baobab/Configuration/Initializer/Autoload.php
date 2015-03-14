<?php

namespace Baobab\Configuration\Initializer;

use Baobab\Blade\Extension;
use Baobab\Blade\WordPressLoopExtension;
use Baobab\Facade\Baobab;
use Baobab\Helper\Paths;
use Baobab\Helper\Strings;
use Baobab\Theme\BaobabTheme;
use Philo\Blade\Blade;

/**
 * Class Autoload
 * @package Baobab\Configuration\Initializer
 *
 *          Automatically load the appropriate classes
 */
class Autoload extends AbstractInitializer
{

    /**
     * Constructor
     *
     * @param array $data The configuration key/value pairs
     */
    public function __construct($data)
    {
        parent::__construct($data);

        /** @var \Composer\Autoload\ClassLoader $classLoader */
        $classLoader = Baobab::classLoader();
        foreach ($data as $prefix => $paths)
        {
            $classLoader->addPsr4($prefix, $paths);
        }
    }
}