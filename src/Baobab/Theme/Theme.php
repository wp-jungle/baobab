<?php

/**
 * Class Theme
 *
 * You should declare in your functions.php file a subclass of this.
 */
class BaobabTheme {

    /** @var BaobabTheme The theme instance */
    private static $instance = null;

    /**
     * Get the unique instance of the theme
     * @return mixed
     */
    public static function getInstance()
    {
        if (is_null(static::$instance))
        {
            static::$instance = new static();
        }
        return static::$instance;
    }

}