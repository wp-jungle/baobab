<?php
/**
 * Created by PhpStorm.
 * User: vprat
 * Date: 14/03/2015
 * Time: 14:48
 */

namespace Baobab\Blade;

use Illuminate\View\Compilers\BladeCompiler;

class WordPressQueryExtension implements Extension
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
        $compiler->directive('wpquery', function ($expression) {
            return "<?php \$__tmp = with{$expression}; if ( \$__tmp->have_posts() ) : while ( \$__tmp->have_posts() ) : \$__tmp->the_post(); ?>";
        });
    }

    /**
     * @emptyloop
     *
     * @param BladeCompiler $compiler The blade compiler to extend
     */
    private function registerEmptyLoopBranch($compiler)
    {
        $compiler->directive('emptywpquery', function ($expression) {
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
        $compiler->directive('endwpquery', function ($expression) {
            return "<?php endif; wp_reset_postdata(); ?>";
        });
    }
}
