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
            'default_path' => Paths::theme('vendor/bundled'),
            'menu'         => dirname(Paths::theme()) . '-install-plugins',
            'has_notices'  => true,
            'dismissable'  => true,
            'dismiss_msg'  => '',
            'is_automatic' => true,
            'message'      => '',
            'strings'      => array(
                'page_title'                      => __( 'Install Required Plugins', 'baobab' ),
                'menu_title'                      => __( 'Install Plugins', 'baobab' ),
                'installing'                      => __( 'Installing Plugin: %s', 'baobab' ), // %s = plugin name.
                'oops'                            => __( 'Something went wrong with the plugin API.', 'baobab' ),
                'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
                'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
                'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
                'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
                'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
                'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
                'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
                'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
                'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
                'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
                'return'                          => __( 'Return to Required Plugins Installer', 'baobab' ),
                'plugin_activated'                => __( 'Plugin activated successfully.', 'baobab' ),
                'complete'                        => __( 'All plugins installed and activated successfully. %s', 'baobab' ), // %s = dashboard link.
                'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
            )
        );

        // Merge user configuration with defaults
        $config = isset($data['options']) ? array_merge_recursive($defaults, $data['options']) : $defaults;

        tgmpa($data['plugins'], $config);
    }
}
