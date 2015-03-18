<?php

namespace Baobab\Configuration\Initializer;

use Baobab\Blade\Extension;
use Baobab\Blade\WordPressLoopExtension;
use Baobab\Facade\Baobab;
use Baobab\Helper\Hooks;
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
     * @param string $id   The ID of the initializer
     * @param array  $data The configuration key/value pairs
     */
    public function __construct($id, $data)
    {
        parent::__construct($id, $data);

        $this->loadPsr4();
        Hooks::action('after_setup_theme', $this, 'instantiateClasses');
    }

    /**
     * Autoload all the classes inside the PSR4 sections for our groups
     */
    public function loadPsr4()
    {
        $data = $this->getData();

        // Always load these
        if (isset($data['always']))
        {
            $this->loadPsr4Group($data['always']);
        }

        // These only in admin
        if (is_admin() && isset($data['admin']))
        {
            $this->loadPsr4Group($data['admin']);
        }

        // These only in frontend
        if ( !is_admin() && isset($data['frontend']))
        {
            $this->loadPsr4Group($data['frontend']);
        }
    }

    /**
     * Automatically instanciate all the classes inside the instanciate sections for our groups
     */
    public function instantiateClasses()
    {
        $data = $this->getData();

        // Always load these
        if (isset($data['always']))
        {
            $this->instantiateGroup($data['always']);
        }

        // These only in admin
        if (is_admin() && isset($data['admin']))
        {
            $this->instantiateGroup($data['admin']);
        }

        // These only in frontend
        if ( !is_admin() && isset($data['frontend']))
        {
            $this->instantiateGroup($data['frontend']);
        }
    }

    /**
     * Autoload the classes for a group
     *
     * @param array $group The group
     */
    private function loadPsr4Group($group)
    {
        if ( !isset($group['psr4']))
        {
            return;
        }

        /** @var \Composer\Autoload\ClassLoader $classLoader */
        $classLoader = Baobab::classLoader();
        foreach ($group['psr4'] as $prefix => $paths)
        {
            $classLoader->addPsr4($prefix, $paths);
        }
    }

    /**
     * Instantiate the classes for a group
     *
     * @param array $group The group
     */
    private function instantiateGroup($group)
    {
        if ( !isset($group['instantiate']))
        {
            return;
        }

        foreach ($group['instantiate'] as $className)
        {
            new $className();
        }
    }
}