<?php
/**
 * Created by PhpStorm.
 * User: vprat
 * Date: 14/03/2015
 * Time: 14:48
 */

namespace Baobab\Blade;

use Illuminate\View\Compilers\BladeCompiler;

class RawPhpExtension implements Extension
{

    /**
     * Register the extension in the compiler
     *
     * @param BladeCompiler $compiler The blade compiler to extend
     */
    public function register($compiler)
    {
        $this->registerRawPhpBraces($compiler);
    }

    /**
     * @shortcode
     *
     * @param BladeCompiler $compiler The blade compiler to extend
     */
    private function registerRawPhpBraces($compiler)
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
                return preg_replace('/#\{\{\s*(.+?)\s*\}\}/s', '<?php $1; ?>', $view);
            });
    }
}