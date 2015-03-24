<?php

namespace Baobab\Configuration\Initializer;

/**
 * Class ThemeSupports
 * @package Baobab\Configuration\Initializer
 *
 *          Registers all the menu locations
 */
class ThemeSupports extends AbstractInitializer
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
    }

    /**
     * Apply the data to configure the theme
     */
    public function run()
    {
        $data = $this->getData();

        foreach ($data as $feature => $value)
        {
            // Allow theme features without options.
            if (is_int($feature))
            {
                add_theme_support($value);
            }
            else
            {
                // Theme features with options.
                add_theme_support($feature, $value);
            }
        }
    }
}