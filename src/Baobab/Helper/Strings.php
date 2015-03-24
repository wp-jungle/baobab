<?php

namespace Baobab\Helper;

class Strings
{

    /**
     * Turn a slug into a human readable label
     *
     * @param string $slug The slug to transform
     *
     * @return string The nice label
     */
    public static function labelizeSlug($slug)
    {
        return ucwords(str_replace(array('-', '_'), ' ', $slug));
    }

    /**
     * Force translation of a string (useful if the string has been loaded before the i18n files have been loaded
     *
     * @param string $str The string to translate
     *
     * @return string The translated string
     */
    public static function translate($str)
    {
        return __($str, BAOBAB_TEXTDOMAIN);
    }

    /**
     * Turn an arbitrary string into a usable javascript variable name
     *
     * @param string $str The string to sanitize
     *
     * @return string The sanitized string
     */
    public static function sanitizeJsVarName($str)
    {
        $out = preg_replace("/ /", '_', trim($str));
        $out = preg_replace("/[^A-Za-z_]/", '', $out);

        return $out;
    }
}