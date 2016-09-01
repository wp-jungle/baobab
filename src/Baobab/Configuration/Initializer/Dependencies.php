<?php

namespace Baobab\Configuration\Initializer;

use Baobab\Blade\Extension;
use Baobab\Blade\WordPressLoopExtension;
use Baobab\Helper\Hooks;
use Baobab\Helper\Paths;
use Baobab\Helper\Strings;
use Philo\Blade\Blade;

/**
 * Class Dependencies
 * @package Baobab\Configuration\Initializer
 *
 *          Initializes theme dependency management via the TGM library
 */
class Dependencies extends AbstractInitializer
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

        require_once(Paths::vendors('tgmpa/tgm-plugin-activation/class-tgm-plugin-activation.php'));
        Hooks::action('tgmpa_register', $this, 'configureTgmPluginActivationLibrary');
    }

    /**
     * Apply the data to configure the theme
     */
    public function configureTgmPluginActivationLibrary()
    {
        $data = $this->getData();

        if ( !isset($data['plugins']) || empty($data['plugins']))
        {
            return;
        }

        // The default TGMPA settings
        $defaults = array(
            'id'           => 'tgmpa-' . dirname(Paths::theme()),
            'default_path' => Paths::theme('vendor/bundled'),
            'menu'         => dirname(Paths::theme()) . '-install-plugins',
            'has_notices'  => true,
            'dismissable'  => true,
            'dismiss_msg'  => '',
            'is_automatic' => true,
            'message'      => '',
        );

        // Merge user configuration with defaults
        $config = isset($data['options']) ? array_merge($defaults, $data['options']) : $defaults;

        tgmpa($data['plugins'], $config);
    }
}
