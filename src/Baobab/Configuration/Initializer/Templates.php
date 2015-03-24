<?php

namespace Baobab\Configuration\Initializer;

use Baobab\Blade\Extension;
use Baobab\Blade\RawPhpExtension;
use Baobab\Blade\WordPressLoopExtension;
use Baobab\Blade\WordPressQueryExtension;
use Baobab\Blade\WordPressShortcodeExtension;
use Baobab\Facade\Baobab;
use Baobab\Helper\Hooks;
use Baobab\Helper\Paths;
use Baobab\Helper\Views;
use Philo\Blade\Blade;

/**
 * Class Templates
 * @package Baobab\Configuration\Initializer
 *
 *          Setup the template system, paths, etc.
 */
class Templates extends AbstractInitializer
{

    /**
     * Constructor
     *
     * @param string $id   The ID of the initializer
     * @param array  $data The configuration key/value pairs
     */
    public function __construct($id, $data)
    {
        parent::__construct($id, $data);

        // If blade is enabled, include required files
        if ($this->isBladeEnabled())
        {
            require_once(Paths::vendors('autoload.php'));
        }

        // Our themes should be properly structured, so we could also provide some common templates within a
        // different folder
        Hooks::filter('get_search_form', $this, 'suggestMoreSearchFormTemplates');
    }

    /**
     * Apply the data to configure the theme
     */
    public function run()
    {
        $data = $this->getData();

        // If blade is enabled, initialize it
        if ($this->isBladeEnabled())
        {
            $bladeConfig = $data['blade'];

            // Setup blade and paths
            $viewsPath = $bladeConfig['paths']['views'];
            $cachePath = $bladeConfig['paths']['cache'];
            $blade = new Blade($viewsPath, $cachePath);

            // Extend blade
            /** @var \Illuminate\View\Compilers\BladeCompiler $compiler */
            $compiler = $blade->getCompiler();
            $extensions = array(
                new RawPhpExtension(),
                new WordPressLoopExtension(),
                new WordPressQueryExtension(),
                new WordPressShortcodeExtension()
            );

            /** @var Extension $ext */
            foreach ($extensions as $ext)
            {
                $ext->register($compiler);
            }

            // Set the blade engine in the facade
            Baobab::setBlade($blade);
        }
    }

    /**
     * @return bool true if the configuration data says that we should enable Blade
     */
    protected function isBladeEnabled()
    {
        $data = $this->getData();

        return $data['engine'] == 'blade' && isset($data['blade']) && !empty($data['blade']);
    }

    /**
     * For themes properly structured, we can find the search form template at
     * app/views/parts/misc/search-form.php. We'll also try a blade template if possible. In order, the templates which
     * will be tried will be:
     *
     * /my-theme/app/views/parts/misc/search-form.blade.php
     * /my-theme/app/views/parts/search-form.blade.php
     * /my-theme/app/views/parts/misc/search-form.php
     * /my-theme/app/views/parts/search-form.php
     * /my-theme/searchform.php
     *
     * @param $form The search form
     *
     * @return string
     */
    public function suggestMoreSearchFormTemplates($form)
    {
        ob_start();

        // Try a blade template first and if not found, try standard PHP templates
        $template = Views::pickView(array('parts.misc.search-form', 'parts.search-form'));
        if ($template != null)
        {
            Views::render(Baobab::blade()->view()->make($template));
        }
        else
        {
            locate_template(array(
                '/app/views/parts/misc/search-form.php',
                '/app/views/parts/search-form.php',
                'searchform.php'
            ), true, false);
        }

        $form = ob_get_clean();

        return $form;
    }
}