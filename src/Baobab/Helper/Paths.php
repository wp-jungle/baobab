<?php

namespace Baobab\Helper;


class Paths
{

    /**
     * @param string $innerPath The path to append to the theme directory without leading slash
     *
     * @return string The absolute path to the theme (with provided relative path appended and without trailing slash)
     */
    public static function theme($innerPath = '')
    {
        $path = untrailingslashit(apply_filters('baobab/paths/theme', get_stylesheet_directory()));

        if (!empty($innerPath)) {
            $innerPath = untrailingslashit($innerPath);
            $path .= '/' . $innerPath;
        }

        return $path;
    }

    /**
     * @param string $innerPath The path to append to the theme directory without leading slash
     *
     * @return string The absolute path to the assets folder for the theme
     */
    public static function assets($innerPath = '')
    {
        $path = 'assets';

        if (!empty($innerPath)) {
            $innerPath = untrailingslashit($innerPath);
            $path .= '/' . $innerPath;
        }

        return apply_filters('baobab/paths/assets', self::theme($path), $innerPath);
    }

    /**
     * @param string $innerPath The path to append to the theme directory without leading slash
     *
     * @return string The absolute path to the storage folder for the theme
     */
    public static function storage($innerPath = '')
    {
        $path = 'app/storage';

        if (!empty($innerPath)) {
            $innerPath = untrailingslashit($innerPath);
            $path .= '/' . $innerPath;
        }

        return apply_filters('baobab/paths/storage', self::theme($path), $innerPath);
    }

    /**
     * @param string $innerPath The path to append to the theme directory without leading slash
     *
     * @return string The absolute path to the configuration folder for the theme
     */
    public static function configuration($innerPath = '')
    {
        $path = 'app/config';

        if (!empty($innerPath)) {
            $innerPath = untrailingslashit($innerPath);
            $path .= '/' . $innerPath;
        }

        return apply_filters('baobab/paths/configuration', self::theme($path), $innerPath);
    }

    /**
     * @param string $innerPath The path to append to the theme directory without leading slash
     *
     * @return string The absolute path to the views folder for the theme
     */
    public static function views($innerPath = '')
    {
        $path = 'app/views';

        if (!empty($innerPath)) {
            $innerPath = untrailingslashit($innerPath);
            $path .= '/' . $innerPath;
        }

        return apply_filters('baobab/paths/views', self::theme($path), $innerPath);
    }

    /**
     * @param string $innerPath The path to append to the directory without leading slash
     *
     * @return string The absolute path to the baobab framework
     */
    public static function baobabFramework($innerPath = '')
    {
        $path = untrailingslashit(dirname(dirname(dirname(dirname(__FILE__)))));

        if (!empty($innerPath)) {
            $innerPath = untrailingslashit($innerPath);
            $path .= '/' . $innerPath;
        }

        return $path;
    }
}