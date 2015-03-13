<?php

namespace Baobab\Theme;

use Baobab\Configuration\Configuration;

/**
 * Class Theme
 *
 * You should declare in your functions.php file a subclass of this.
 */
abstract class BaobabTheme
{

    //------------------------------------------------------------------------------------------------------------------
    // You can override this in your main theme class

    public static $configurationMappings = array();

    //------------------------------------------------------------------------------------------------------------------
    // Singleton access to the theme class. The child class must have a protected static $instance member variable

    /**
     * Get the unique instance of the theme
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

    protected function __construct()
    {
        $this->configuration = Configuration::create(static::$configurationMappings);
    }

}