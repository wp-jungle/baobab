<?php

namespace Baobab\Theme;

use Baobab\Configuration\Configuration;
use Baobab\Helper\Hooks;
use Philo\Blade\Blade;

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
        // Load configuration
        $this->configuration = Configuration::create(static::$configurationMappings);

        // Load text domain
        Hooks::action('after_setup_theme', $this, 'bootstrap', 5);
    }

    public function bootstrap()
    {
        // Apply configuration
        $this->configuration->apply();
    }

}