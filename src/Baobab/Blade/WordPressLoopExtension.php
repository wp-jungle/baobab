<?php
/**
 * Created by PhpStorm.
 * User: vprat
 * Date: 14/03/2015
 * Time: 14:48
 */

namespace Baobab\Blade;

use Illuminate\View\Compilers\BladeCompiler;

class WordPressLoopExtension implements Extension {

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
     * @wpquery
     *
     * @param BladeCompiler $compiler The blade compiler to extend
     */
    private function registerStartLoopQuery($compiler)
    {
        $compiler->extend(function($value, $view) {
            $pattern = '/(\s*)@wpquery(\s*\(.*\))/';
            $replacement  = '$1<?php $bladequery = new WP_Query$2; ';
            $replacement .= 'if ( $bladequery->have_posts() ) : ';
            $replacement .= 'while ( $bladequery->have_posts() ) : ';
            $replacement .= '$bladequery->the_post(); ?> ';
            return preg_replace( $pattern, $replacement, $value );
        });
    }

    /**
     * @wpempty
     *
     * @param BladeCompiler $compiler The blade compiler to extend
     */
    private function registerEmptyLoopBranch($compiler)
    {
        $compiler->extend(function($value, $view) {
            return str_replace('@wpempty', '<?php endwhile; ?><?php else: ?>', $value);
        });
    }

    /**
     * @wpend
     *
     * @param BladeCompiler $compiler The blade compiler to extend
     */
    private function registerEndLoop($compiler)
    {
        $compiler->extend(function($value, $view) {
            return str_replace('@wpend', '<?php endif; wp_reset_postdata(); ?>', $value);
        });
    }
}