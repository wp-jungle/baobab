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
     * @param array $data The configuration key/value pairs
     */
    public function __construct($data)
    {
        parent::__construct($data);

        require_once(Paths::baobabFramework('vendor/tgm/plugin-activation/class-tgm-plugin-activation.php'));
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
                'page_title'                      => Strings::translate('Install Required Plugins'),
                'menu_title'                      => Strings::translate('Install Plugins'),
                'installing'                      => Strings::translate('Installing Plugin: %s'), // %s = plugin name.
                'oops'                            => Strings::translate('Something went wrong with the plugin API.'),
                'notice_can_install_required'     => Strings::translate('This theme requires the following plugin: %1$s.'),
                'notice_can_install_recommended'  => Strings::translate('This theme recommends the following plugin: %1$s.'),
                'notice_cannot_install'           => Strings::translate('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.'),
                'notice_can_activate_required'    => Strings::translate('The following required plugin is currently inactive: %1$s.'),
                'notice_can_activate_recommended' => Strings::translate('The following recommended plugin is currently inactive: %1$s.'),
                'notice_cannot_activate'          => Strings::translate('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.'),
                'notice_ask_to_update'            => Strings::translate('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.'),
                'notice_cannot_update'            => Strings::translate('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.'),
                'install_link'                    => Strings::translate('Begin installing plugin', 'Begin installing plugins'),
                'activate_link'                   => Strings::translate('Begin activating plugin', 'Begin activating plugins'),
                'return'                          => Strings::translate('Return to Required Plugins Installer'),
                'plugin_activated'                => Strings::translate('Plugin activated successfully.'),
                'complete'                        => Strings::translate('All plugins installed and activated successfully. %s'),
                'nag_type'                        => 'updated'
            )
        );

        // Merge user configuration with defaults
        $config = isset($data['options']) ? array_merge_recursive($defaults, $data['options']) : $defaults;

        tgmpa($data['plugins'], $config);
    }
}