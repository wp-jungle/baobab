<?php

namespace Baobab\Configuration\Initializer;

use Baobab\Helper\Strings;

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
        $locations = array();
        $data = $this->getData();
        foreach ($data as $slug => $desc)
        {
            $locations[$slug] = Strings::translate($desc);
        }
        register_nav_menus($locations);
    }
}