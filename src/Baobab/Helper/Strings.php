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

}