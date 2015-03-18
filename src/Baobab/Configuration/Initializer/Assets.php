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
     * @param string $id   The ID of the initializer
     * @param array  $data The configuration key/value pairs
     */
    public function __construct($id, $data)
    {
        parent::__construct($id, $data);
        Hooks::action('wp_enqueue_scripts', $this, 'registerAssets', 99);
        Hooks::action('wp_enqueue_scripts', $this, 'enqueueAssets', 100);
    }

    /**
     * Register the assets before we eventually enqueue them
     */
    public function registerAssets()
    {
        $data = $this->getData();

        // Read the assets manifest file if it exists
        $manifest = $this->loadManifest();

        if (isset($data['styles']))
        {
            foreach ($data['styles'] as $handle => $props)
            {
                $this->handleStyleAction('register', $handle, $props, $manifest);
            }
        }

        if (isset($data['scripts']))
        {
            foreach ($data['scripts'] as $handle => $props)
            {
                $this->handleScriptAction('register', $handle, $props, $manifest);
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

    /**
     * Do something with an asset
     *
     * @param string       $actionType Either 'register' or 'enqueue'
     * @param string       $handle     The handle of the asset
     * @param string|array $props      The properties describing the asset
     * @param object|null  $manifest   The asset manifest file if it exists
     */
    private function handleStyleAction($actionType, $handle, $props, $manifest = null)
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
            // Set the version number from the manifest if it specifies one
            if ($manifest != null && isset($manifest[$handle]) && isset($manifest[$handle]['hash']))
            {
                $props['ver'] = $manifest[$handle]['hash'];
            }

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

    /**
     * Do something with an asset
     *
     * @param string       $actionType Either 'register' or 'enqueue'
     * @param string       $handle     The handle of the asset
     * @param string|array $props      The properties describing the asset
     * @param object|null  $manifest   The asset manifest file if it exists
     */
    private function handleScriptAction($actionType, $handle, $props, $manifest = null)
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
            // Set the version number from the manifest if it specifies one
            if ($manifest != null && isset($manifest[$handle]) && isset($manifest[$handle]['hash']))
            {
                $props['ver'] = $manifest[$handle]['hash'];
            }

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

    /**
     * Read the manifest file that can be found at the root of the theme's asset folder.
     *
     * @return object|null null if the file does not exist or an object representing the manifest data
     */
    protected function loadManifest()
    {
        $manifestPath = Paths::assets('manifest.json');

        if (file_exists($manifestPath))
        {
            return json_decode(file_get_contents($manifestPath), true);
        }

        return null;
    }
}