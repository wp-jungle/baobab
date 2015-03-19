<?php

namespace Baobab\Configuration\Initializer;

use Baobab\Configuration\Exception\InvalidConfigurationException;
use Baobab\Helper\Hooks;
use Baobab\Helper\Paths;

/**
 * Class ThemeSettings
 * @package Baobab\Configuration\Initializer
 *
 *          Registers some general settings of the theme (e.g. text domain, ...)
 */
class ThemeSettings extends AbstractInitializer
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

        // Define the theme text domain constant as early as possible
        if ( !isset($data['text_domain']))
        {
            throw new InvalidConfigurationException('\Baobab\Configuration\Initializer\ThemeSettings', 'text_domain');
        }
        define('BAOBAB_TEXTDOMAIN', $data['text_domain']);

        // Some restrictions
        $this->restrictAdminBarVisibility();
        $this->restrictAdminPanelAccess();
    }

    /**
     * Apply the data to configure the theme
     */
    public function run()
    {
        $data = $this->getData();

        // Load translations
        load_theme_textdomain($data['text_domain'], Paths::theme('languages'));
    }

    /**
     * Restrict visiblity of the admin bar
     */
    public function restrictAdminBarVisibility()
    {
        // Don't go further if not logged in or within admin panel
        if (is_admin() || !is_user_logged_in())
        {
            return;
        }

        $data = $this->getData();

        // Don't go further if no setting
        if ( !isset($data['admin_bar']) || empty($data['admin_bar']))
        {
            return;
        }

        $access = $data['admin_bar'];

        // Is current user's role within our access roles?
        $user = wp_get_current_user();
        $role = $user->roles;
        $role = (count($role) > 0) ? $role[0] : '';
        $isUserIncluded = in_array($role, $access['roles']);

        // Hide admin bar if required
        if (($access['mode'] == 'show' && !$isUserIncluded)
            || ($access['mode'] == 'hide' && $isUserIncluded)
        )
        {
            show_admin_bar(false);
        }
    }

    /**
     * Restrict access to the wp-admin.
     */
    private function restrictAdminPanelAccess()
    {
        // Don't restrict anything when doing AJAX or CLI stuff
        if ((defined('DOING_AJAX') && DOING_AJAX) || (defined('WP_CLI') && WP_CLI) || !is_user_logged_in())
        {
            return;
        }

        $data = $this->getData();

        // Don't go further if no setting
        if ( !isset($data['admin_access']) || empty($data['admin_access']) || !is_admin())
        {
            return;
        }

        $access = $data['admin_access'];

        // Is current user's role within our access roles?
        $user = wp_get_current_user();
        $role = $user->roles;
        $role = (count($role) > 0) ? $role[0] : '';
        $isUserIncluded = in_array($role, $access['roles']);

        // Redirect to website home if required
        if (($access['mode'] == 'allow' && !$isUserIncluded)
            || ($access['mode'] == 'forbid' && $isUserIncluded)
        )
        {
            wp_redirect(home_url());
            exit;
        }
    }
}