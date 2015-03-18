<?php

namespace Baobab\Configuration\Initializer;

use Baobab\Blade\Extension;
use Baobab\Blade\WordPressLoopExtension;
use Baobab\Blade\WordPressQueryExtension;
use Baobab\Blade\WordPressShortcodeExtension;
use Baobab\Facade\Baobab;
use Baobab\Helper\Paths;
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
     * @param array $data The configuration key/value pairs
     */
    public function __construct($data)
    {
        parent::__construct($data);

        // If blade is enabled, include required files
        if ($this->isBladeEnabled())
        {
            require_once(Paths::baobabFramework('vendor/autoload.php'));
        }
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
}