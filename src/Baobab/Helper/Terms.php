<?php

namespace Baobab\Helper;

/**
 * Class Terms
 * @package Baobab\Helper
 *
 *          Provides various functions that help making cleaner template files in the theme
 */
class Terms
{

    /**
     * Implode the slugs of the provided terms
     *
     * @param string $glue The glue between each token
     * @param array $terms The terms to use
     *
     * @return string
     */
    public static function implodeSlugs($glue, $terms)
    {
        if ($terms==null || empty($terms) || is_wp_error($terms)) return '';

        $tokens = array();
        foreach ($terms as $t)
        {
            $tokens[] = $t->slug;
        }

        return implode($glue, $tokens);
    }

    /**
     * Implode the names of the provided terms
     *
     * @param string $glue The glue between each token
     * @param array $terms The terms to use
     *
     * @return string
     */
    public static function implodeNames($glue, $terms)
    {
        if ($terms==null || empty($terms) || is_wp_error($terms)) return '';

        $tokens = array();
        foreach ($terms as $t)
        {
            $tokens[] = $t->name;
        }

        return implode($glue, $tokens);
    }

}