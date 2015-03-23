<?php

namespace Baobab\Configuration\Initializer;

use Baobab\Helper\Hooks;
use Baobab\Helper\Paths;
use Baobab\Helper\Strings;
use Baobab\Helper\Urls;

/**
 * Class Customizer
 * @package Baobab\Configuration\Initializer
 *
 *          Setup the theme customizer
 */
class Customizer extends AbstractInitializer
{

    private static $OPTIONS_DEFAULTS = array(
        'color_active'  => '#1abc9c',
        'color_light'   => '#8cddcd',
        'color_select'  => '#34495e',
        'color_accent'  => '#FF5740',
        'color_back'    => '#343434',
        'stylesheet_id' => 'shoestrap',
    );

    /**
     * Constructor
     *
     * @param string $id The ID of the initializer
     * @param array $data The configuration key/value pairs
     */
    public function __construct($id, $data)
    {
        parent::__construct($id, $data);

        // Boostrap Kirki
        Hooks::filter('kirki/config', $this, 'configureKirki');
        Hooks::filter('customize_register', $this, 'createPanels');
        Hooks::filter('kirki/controls', $this, 'registerControls');

        /** @noinspection PhpIncludeInspection */
        require_once(Paths::baobabFramework('vendor/aristath/kirki/kirki.php'));
    }

    /**
     * Configure the Kirki library
     */
    public function configureKirki()
    {
        // These cannot be setup above directly, do it now
        self::$OPTIONS_DEFAULTS['logo_image'] = Urls::assets('images/admin/customizer.png');
        self::$OPTIONS_DEFAULTS['url_path'] = Urls::baobabFramework('vendor/aristath/kirki/');
        // Todo pull description from somewhere where it is already defined
        self::$OPTIONS_DEFAULTS['description'] = Strings::translate('This is the theme description');

        $data = $this->getData();

        return array_merge(self::$OPTIONS_DEFAULTS, $data['options']);
    }

    /**
     * Register the controls in the various panels and sections
     * @param array $controls The controls to register
     * @return array The augmented controls array
     */
    public function registerControls($controls)
    {
        $data = $this->getData();
        return array_merge($controls, $data['controls']);
    }

    /**
     * Create all panels and sections
     *
     * @param \WP_Customize_Manager $wp_customize the WP customizer
     * @return \WP_Customize_Manager
     */
    public function createPanels($wp_customize)
    {
        $data = $this->getData();
        $panels = $data['panels'];

        $panelPriority = 1000;

        foreach ($panels as $panelProps) {
            $panelId = 'panel-' . $panelPriority;

            $wp_customize->add_panel($panelId, array(
                'priority'    => $panelPriority,
                'title'       => Strings::translate($panelProps['title']),
                'description' => Strings::translate($panelProps['description'])
            ));

            $sectionPriority = 10;
            foreach ($panelProps['sections'] as $sectionId => $sectionProps) {
                $wp_customize->add_section($sectionId, array(
                    'panel'       => $panelId,
                    'priority'    => $sectionPriority,
                    'title'       => Strings::translate($sectionProps['title']),
                    'description' => Strings::translate($sectionProps['description'])

                ));

                $sectionPriority += 10;
            }

            $panelPriority += 10;
        }

        return $wp_customize;
    }
}