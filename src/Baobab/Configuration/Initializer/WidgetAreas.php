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

        $defaultProperties = $data['defaults'];
        $areas = $data['areas'];

        foreach ($areas as $slug => $desc)
        {
            // Handle quick declaration style
            if ( !is_array($desc))
            {
                // $desc is actually the title, build an array
                $desc = array('name' => $desc);
            }

            // Set name and description if not specified
            if ( !isset($desc['name']))
            {
                $desc['name'] = Strings::labelizeSlug($slug);
            }
            if ( !isset($desc['description']))
            {
                $desc['description'] = '';
            }

            // Set the slug
            $desc['id'] = $slug;

            // Merge with our default and register
            $areaProperties = array_merge($defaultProperties, $desc);

            // Internationalize what has to be internationalized
            $areaProperties['name'] = Strings::translate($areaProperties['name']);
            $areaProperties['description'] = Strings::translate($areaProperties['description']);

            register_sidebar($areaProperties);
        }
    }
}