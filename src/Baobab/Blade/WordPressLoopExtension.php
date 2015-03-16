<?php
/**
 * Created by PhpStorm.
 * User: vprat
 * Date: 14/03/2015
 * Time: 14:48
 */

namespace Baobab\Blade;

use Illuminate\View\Compilers\BladeCompiler;

class WordPressLoopExtension implements Extension
{

    /**
     * Register the extension in the compiler
     *
     * @param BladeCompiler $compiler The blade compiler to extend
     */
    public function register($compiler)
    {
        $this->registerStartLoopQuery($compiler);
        $this->registerEmptyLoopBranch($compiler);
        $this->registerEndLoop($compiler);
    }

    /**
     * @wploop
     *
     * @param BladeCompiler $compiler The blade compiler to extend
     */
    private function registerStartLoopQuery($compiler)
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
                $pattern = $comp->createPlainMatcher('wploop');
                $replacement = '$1<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?> ';

                return preg_replace($pattern, $replacement, $view);
            });
    }

    /**
     * @emptyloop
     *
     * @param BladeCompiler $compiler The blade compiler to extend
     */
    private function registerEmptyLoopBranch($compiler)
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
                $pattern = $comp->createPlainMatcher('emptywploop');
                $replacement = '$1<?php endwhile; ?><?php else: ?>';

                return preg_replace($pattern, $replacement, $view);
            });
    }

    /**
     * @wpend
     *
     * @param BladeCompiler $compiler The blade compiler to extend
     */
    private function registerEndLoop($compiler)
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
                $pattern = $comp->createPlainMatcher('endwploop');
                $replacement = '$1<?php endif; wp_reset_postdata(); ?>';

                return preg_replace($pattern, $replacement, $view);
            });
    }
}