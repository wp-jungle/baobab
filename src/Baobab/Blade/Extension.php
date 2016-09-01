<?php

namespace Baobab\Blade;

use Illuminate\View\Compilers\BladeCompiler;

/**
 * Interface Extension
 *
 * @package Baobab\Blade
 *
 *          Extend the blade compiler
 */
interface Extension
{

    /**
     * Register the extension in the compiler
     *
     * @param BladeCompiler $compiler The blade compiler to extend
     */
    public function register($compiler);

}