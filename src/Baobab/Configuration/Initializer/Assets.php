<?php

namespace Baobab\Configuration\Initializer;

use Baobab\Blade\Extension;
use Baobab\Blade\WordPressLoopExtension;
use Baobab\Facade\Baobab;
use Baobab\Helper\Hooks;
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

    private static $STYLE_DEFAULTS = array(
        'src'        => null,
        'deps'       => array(),
        'ver'        => false,
        'media'      => 'all',
        'unregister' => false,
        'predicate'  => null
    );

    private static $SCRIPT_DEFAULTS = array(
        'src'        => null,
        'deps'       => array(),
        'ver'        => false,
        'in_footer'  => false,
        'unregister' => false,
        'predicate'  => null
    );

    /**
     * Constructor
     *
     * @param array $data The configuration key/value pairs
     */
    public function __construct($data)
    {
        parent::__construct($data);
        Hooks::action('wp_enqueue_scripts', $this, 'registerAssets', 99);
        Hooks::action('wp_enqueue_scripts', $this, 'enqueueAssets', 100);
    }

    /**
     * Register the assets before we eventually enqueue them
     */
    public function registerAssets()
    {
        $data = $this->getData();

        if (isset($data['styles']))
        {
            foreach ($data['styles'] as $handle => $props)
            {
                $this->handleStyleAction('register', $handle, $props);
            }
        }

        if (isset($data['scripts']))
        {
            foreach ($data['scripts'] as $handle => $props)
            {
                $this->handleScriptAction('register', $handle, $props);
            }
        }
    }

    /**
     * Enqueue the assets
     */
    public function enqueueAssets()
    {
        $data = $this->getData();

        if (isset($data['editor']))
        {
            // Tell the TinyMCE editor to use a custom stylesheet
            add_editor_style($data['editor']);
        }

        if (isset($data['styles']))
        {
            foreach ($data['styles'] as $handle => $props)
            {
                $this->handleStyleAction('enqueue', $handle, $props);
            }
        }

        if (isset($data['scripts']))
        {
            foreach ($data['scripts'] as $handle => $props)
            {
                $this->handleScriptAction('enqueue', $handle, $props);
            }
        }
    }

    private function handleStyleAction($actionType, $handle, $props)
    {
        // Handle short declaration style
        if (is_string($props))
        {
            $props = array('src' => $props);
        }

        // Merge default values
        $props = array_merge(self::$STYLE_DEFAULTS, $props);

        // Unregister if required
        if ($actionType == 'register' && $props['unregister'] === true)
        {
            wp_deregister_script($handle);
        }

        // Register the script if we have an src and the predicate is true
        $predicate = $props['predicate'];
        if ($props['src'] !== null && ($predicate == null || $predicate() == true))
        {
            switch ($actionType)
            {
                case 'register':
                    wp_register_style($handle, $props['src'], $props['deps'], $props['ver'], $props['media']);
                    break;
                case 'enqueue':
                    wp_enqueue_style($handle);
                    break;
            }
        }
    }

    private function handleScriptAction($actionType, $handle, $props)
    {
        // Handle short declaration style
        if (is_string($props))
        {
            $props = array('src' => $props);
        }

        // Merge default values
        $props = array_merge(self::$SCRIPT_DEFAULTS, $props);

        // Unregister if required
        if ($actionType == 'register' && $props['unregister'] === true)
        {
            wp_deregister_script($handle);
        }

        // Register the script if we have an src and the predicate is true
        $predicate = $props['predicate'];
        if ($props['src'] !== null && ($predicate == null || $predicate() == true))
        {
            switch ($actionType)
            {
                case 'register':
                    wp_register_script($handle, $props['src'], $props['deps'], $props['ver'], $props['in_footer']);
                    break;
                case 'enqueue':
                    wp_enqueue_script($handle);
                    break;
            }
        }
    }
}