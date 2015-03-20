<?php

namespace Baobab\Theme;

use Baobab\Configuration\Configuration;
use Baobab\Facade\Baobab;
use Baobab\Helper\Hooks;
use Baobab\Loader\ObjectRegistry;
use Baobab\Theme\Exception\ThemeDeclarationException;

/**
 * Class Theme
 *
 * You should declare in your functions.php file a subclass of this.
 */
abstract class BaobabTheme
{

    //------------------------------------------------------------------------------------------------------------------
    // You must override these in your main theme class

    public static $instance = null;

    //------------------------------------------------------------------------------------------------------------------
    // You can override these in your main theme class

    public static $configurationMappings = array();

    //------------------------------------------------------------------------------------------------------------------
    // Singleton access to the theme class. The child class must have a protected static $instance member variable

    /**
     * Get the unique instance of the theme
     *
     * @return mixed
     */
    public static function getInstance()
    {
        if (is_null(static::$instance))
        {
            static::$instance = new static();
        }

        return static::$instance;
    }

    //------------------------------------------------------------------------------------------------------------------
    // The components of the theme

    /** @var \Baobab\Configuration\Configuration The theme configuration */
    protected $configuration = null;

    /**
     * Constructor
     */
    protected function __construct()
    {
        // Gather some variables from the child class
        $this->loadStaticChildClassMembers();

        // Load configuration
        $this->configuration = Configuration::create(static::$configurationMappings);

        // Load text domain
        Hooks::action('after_setup_theme', $this, 'setup', 5);
    }

    /**
     * Function that is run by the 'after_setup_theme' WordPress hook. Basically loads the configuration.
     */
    public function setup()
    {
        // Apply configuration
        $this->configuration->apply();
    }

    /**
     * Gather some variables from the child class
     */
    protected function loadStaticChildClassMembers()
    {
        if (is_null(static::$classLoader))
        {
            throw new ThemeDeclarationException('You must specify a class loader in your child theme class');
        }

        Baobab::setObjectRegistry(new ObjectRegistry(static::$classLoader));
    }
}