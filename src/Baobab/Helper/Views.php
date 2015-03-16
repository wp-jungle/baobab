<?php

namespace Baobab\Helper;

/**
 * Class Views
 * @package Baobab\Helper
 *
 *          Provides helper functions to manipulate and render views
 */
class Views {

    /**
     * Use this in your templates to render views returned by the controllers
     *
     * @param \Illuminate\View\View $view The view to be rendered
     */
    public static function render($view) {
        try
        {
            echo $view->render();
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }
    }

}