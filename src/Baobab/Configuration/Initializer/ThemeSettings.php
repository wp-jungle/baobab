<?php

namespace Baobab\Configuration\Initializer;

use Baobab\Configuration\Exception\InvalidConfigurationException;
use Baobab\Helper\Paths;

/**
 * Class ThemeSettings
 * @package Baobab\Configuration\Initializer
 *
 *          Registers some general settings of the theme (e.g. text domain, ...)
 */
class ThemeSettings extends AbstractInitializer
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

        // Define the theme text domain constant as early as possible
        if ( !isset($data['text_domain']))
        {
            throw new InvalidConfigurationException('\Baobab\Configuration\Initializer\ThemeSettings', 'text_domain');
        }
        define('BAOBAB_TEXTDOMAIN', $data['text_domain']);
    }

    /**
     * Apply the data to configure the theme
     */
    public function run()
    {
        $data = $this->getData();

        // Load translations
        load_theme_textdomain($data['text_domain'], Paths::theme('languages'));
    }
}