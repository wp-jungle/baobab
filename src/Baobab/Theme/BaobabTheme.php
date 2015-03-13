<?php

namespace Baobab\Theme;

use Baobab\Configuration\Configuration;
use Baobab\Helper\Hooks;
use Baobab\Helper\Paths;
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

    public static $textDomain = null;
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
            self::checkRequiredStaticFields();
            self::defineConstants();

            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Access the text domain defined by our child class
     *
     * @return string The text domain
     */
    public static function textDomain()
    {
        return static::$textDomain;
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
        // Load translations
        $this->loadTextDomain();

        // Apply configuration
        $this->configuration->apply();
    }

    /**
     * Load the theme translations
     */
    protected function loadTextDomain()
    {
        load_theme_textdomain(BAOBAB_TEXTDOMAIN, Paths::theme('languages'));
    }

    /**
     * Check that the mandatory static fields are properly overridden
     *
     * @throws ThemeDeclarationException When the child class fails to declare some required properties
     */
    protected static function checkRequiredStaticFields()
    {
        if (is_null(static::$textDomain))
        {
            throw new ThemeDeclarationException(
                'You must declare the text domain in your BaobabTheme child class as a static property');
        }
    }

    /**
     * Turn some of the class static members into constants for performance
     */
    protected static function defineConstants()
    {
        define('BAOBAB_TEXTDOMAIN', static::$textDomain);
    }

}