<?php

namespace Baobab\Configuration\Initializer;

use Baobab\Blade\Extension;
use Baobab\Blade\WordPressLoopExtension;
use Baobab\Facade\Baobab;
use Baobab\Helper\Paths;
use Baobab\Helper\Strings;
use Philo\Blade\Blade;

/**
 * Class Assets
 * @package Baobab\Configuration\Initializer
 *
 *          Enqueues the assets used by the theme
 */
class Assets extends AbstractInitializer
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

        if (isset($data['editor']))
        {
            // Tell the TinyMCE editor to use a custom stylesheet
            add_editor_style($data['editor']);
        }

        if (isset($data['styles']))
        {
            $defaults = array(
                'deps' => array(),
                'ver' => false,
                'media' => 'all'
            );

            foreach ($data['styles'] as $handle => $props)
            {
                if (isset($props['unregister']) && $props['unregister']==true)
                {
                    wp_deregister_style($handle);
                }

                $props = array_merge($defaults, $props);
                wp_register_style($handle, $props['src'], $props['deps'], $props['ver'], $props['media']);
            }
        }

        if (isset($data['scripts']))
        {
            $defaults = array(
                'deps' => array(),
                'ver' => false,
                'in_footer' => false
            );

            foreach ($data['scripts'] as $handle => $props)
            {
                if (isset($props['unregister']) && $props['unregister']==true)
                {
                    wp_deregister_script($handle);
                }

                $props = array_merge($defaults, $props);
                wp_register_script($handle, $props['src'], $props['deps'], $props['ver'], $props['in_footer']);
            }
        }
    }
}