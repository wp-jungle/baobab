<?php

namespace Baobab\Configuration\Initializer;

use Baobab\Helper\Strings;

/**
 * Class WidgetAreas
 * @package Baobab\Configuration\Initializer
 *
 *          Registers all the widget areas
 */
class WidgetAreas extends AbstractInitializer
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
        $data = $this->getData();

        $defaultProperties = $data['defaults'];
        $areas = $data['areas'];

        foreach ($areas as $slug => $desc)
        {
            // Handle quick declaration style
            if (!is_array($desc)) {
                // $desc is actually the title, build an array
                $desc = array('name' => $desc);
            }

            // Set the name if not specified
            if (!isset($desc['name'])) {
                $desc['name'] = Strings::labelizeSlug($slug);
            }

            // Set the slug
            $desc['id'] = $slug;

            // Merge with our default and register
            $areaProperties = array_merge($defaultProperties, $desc);
            register_sidebar($areaProperties);
        }
    }
}