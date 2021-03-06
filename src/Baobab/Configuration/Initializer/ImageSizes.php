<?php

namespace Baobab\Configuration\Initializer;

use Baobab\Helper\Hooks;
use Baobab\Helper\Strings;

/**
 * Class ImageSizes
 * @package Baobab\Configuration\Initializer
 *
 *          Initialises all the theme's image sizes
 */
class ImageSizes extends AbstractInitializer
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
        parent::run();

        // Register image sizes
        $this->addImageSizes();

        // Add sizes to the media attachment settings dropdown list.
        Hooks::action('image_size_names_choose', $this, 'addSizesToDropDownList');
    }

    /**
     * Loop through the registered image sizes and add them.
     *
     * @return void
     */
    private function addImageSizes()
    {
        $data = $this->getData();
        foreach ($data as $slug => $props)
        {
            add_image_size($slug, $props['width'], $props['height'], $props['crop']);
        }
    }

    /**
     * Add image sizes to the media size dropdown list.
     *
     * @param array $sizes The existing sizes.
     *
     * @return array
     */
    public function addSizesToDropDownList($sizes)
    {
        $new = array();

        $data = $this->getData();
        foreach ($data as $slug => $props)
        {
            // If no 4th option, stop the loop.
            if ( !isset($props['media']) || false == $props['media'])
            {
                continue;
            }

            $new[$slug] = isset($props['mediaLabel']) ? $props['mediaLabel'] : Strings::labelizeSlug($slug);

            // Internationalize what has to be
            $new[$slug] = Strings::translate($new[$slug]);
        }

        return array_merge($sizes, $new);
    }
}