<?php

namespace Baobab\Configuration\Initializer;

/**
 * Class MenuLocations
 * @package Baobab\Configuration\Initializer
 *
 *          Registers all the menu locations
 */
class MenuLocations extends AbstractInitializer
{

    /**
     * Constructor
     *
     * @param array $data The configuration key/value pairs
     */
    public function __construct($data)
    {
        parent::__construct($data);
    }

    /**
     * Apply the data to configure the theme
     */
    public function run()
    {
        $locations = array();
        $data = $this->getData();
        foreach ($data as $slug => $desc)
        {
            $locations[$slug] = $desc;
        }
        register_nav_menus($locations);
    }
}