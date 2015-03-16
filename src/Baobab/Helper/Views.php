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

    /**
     * Pick the first view found in the stack
     *
     * @param array $stack A list of view names by priority order
     *
     * @return null|string The first view that really exists or null if no view was found
     */
    public static function pickView($stack)
    {
        $viewRoot = trailingslashit(Paths::views());
        foreach ($stack as $id)
        {
            $innerPath = str_replace('.', '/', $id);
            $innerPath .= '.blade.php';

            if (file_exists($viewRoot . $innerPath)) return $id;
        }
        return null;
    }

}