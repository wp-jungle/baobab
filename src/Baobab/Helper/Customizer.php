<?php

namespace Baobab\Helper;

/**
 * Class Customizer
 * @package Baobab\Helper
 *
 * Functions to help build the app/config/customizer.config.php file
 */
class Customizer
{

    /**
     * Define a customizer panel. The function accepts more than 2 arguments. All arguments passed after the description
     * will define the sections of the panel.
     *
     * @param string $title
     * @param string $description
     * @return array
     */
    public static function panel($title, $description)
    {
        $argCount = func_num_args();
        $args = func_get_args();

        $sections = array();
        for ($i = 2; $i < $argCount; ++$i) {
            $sections[$args[$i]['id']] = $args[$i];
        }

        return array(
            'title'       => $title,
            'description' => $description,
            'sections'    => $sections
        );
    }

    /**
     * define a section within a customizer panel
     * @param string $id
     * @param string $title
     * @param string $description
     * @return array
     */
    public static function section($id, $title, $description)
    {
        return array(
            'id'          => $id,
            'title'       => $title,
            'description' => $description
        );
    }

    /**
     * @link http://kirki.org/#field-arguments
     *
     * @param $type
     * @param $id
     * @param $sectionId
     * @param $label
     * @param int $default
     * @param int $priority
     * @param string $description
     * @param string $help
     * @param array $choices
     * @param array $output
     * @param string $transport
     * @param null $sanitize_callback
     * @return array
     */
    public static function control($type,
                                   $id,
                                   $sectionId,
                                   $label,
                                   $default = 0,
                                   $priority = 10,
                                   $description = '',
                                   $help = '',
                                   $choices = array(),
                                   $output = array(),
                                   $transport = 'refresh',
                                   $sanitize_callback = null)
    {

        return array(
            'type'              => $type,
            'settings'          => $id,
            'label'             => $label,
            'section'           => $sectionId,
            'default'           => $default,
            'priority'          => $priority,
            'description'       => $description,
            'help'              => $help,
            'choices'           => $choices,
            'output'            => $output,
            'transport'         => $transport,
            'sanitize_callback' => $sanitize_callback
        );

    }

}