<?php
/**
 * Created by PhpStorm.
 * User: vprat
 * Date: 14/03/2015
 * Time: 14:48
 */

namespace Baobab\Blade;

use Illuminate\View\Compilers\BladeCompiler;

class WordPressShortcodeExtension implements Extension
{

    /**
     * Register the extension in the compiler
     *
     * @param BladeCompiler $compiler The blade compiler to extend
     */
    public function register($compiler)
    {
        $this->registerDoShortcode($compiler);
    }

    /**
     * @shortcode
     *
     * @param BladeCompiler $compiler The blade compiler to extend
     */
    private function registerDoShortcode($compiler)
    {
        $compiler->extend(
        /**
         * @param string        $view The view currently being rendered
         * @param BladeCompiler $comp The compiler currently used
         *
         * @return string The compiled view
         */
            function ($view, $comp)
            {
                $pattern = $comp->createMatcher('shortcode');
                $replacement = '$1<?php do_shortcode($2); ?> ';

                return preg_replace($pattern, $replacement, $view);
            });
    }
}