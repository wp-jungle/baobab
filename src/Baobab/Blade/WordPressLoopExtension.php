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
        $compiler->directive('wploop', function ($expression) {
            return "<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>";
        });
    }

    /**
     * @emptyloop
     *
     * @param BladeCompiler $compiler The blade compiler to extend
     */
    private function registerEmptyLoopBranch($compiler)
    {
        $compiler->directive('emptywploop', function ($expression) {
            return "<?php endwhile; ?><?php else: ?>";
        });
    }

    /**
     * @wpend
     *
     * @param BladeCompiler $compiler The blade compiler to extend
     */
    private function registerEndLoop($compiler)
    {
        $compiler->directive('endwploop', function ($expression) {
            return "<?php endif; wp_reset_postdata(); ?>";
        });
    }
}