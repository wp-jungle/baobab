<?php

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
        $compiler->directive('shortcode', function ($expression) {
            return "<?php do_shortcode(with{$expression}); ?>";
        });
    }
}