<?php

namespace Baobab\Helper;

class Urls
{

    /**
     * @param string $innerPath The path to append to the theme directory without leading slash
     *
     * @return string The absolute path to the theme (with provided relative path appended and without trailing slash)
     */
    public static function theme($innerPath = '')
    {
        $path = untrailingslashit(apply_filters('baobab/urls/theme', get_stylesheet_directory_uri()));

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

        return apply_filters('baobab/urls/assets', self::theme($path), $innerPath);
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

        return apply_filters('baobab/urls/storage', self::theme($path), $innerPath);
    }
}