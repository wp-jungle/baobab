<?php

namespace Baobab\Configuration;

use Baobab\Configuration\Exception\ConfigurationNotFoundException;
use Baobab\Configuration\Parser\PhpParser;
use Baobab\Helper\Hooks;
use Baobab\Helper\Paths;
use Baobab\Theme\Exception\ThemeDeclarationException;

/**
 * Class Configuration
 * @package Baobab\Configuration
 *
 *          Parses and applies the theme configuration files
 */
class Configuration
{
    /** The namespace where we find our core initializers */
    const DEFAULT_INITIALIZER_NS = '\Baobab\Configuration\Initializer';

    //------------------------------------------------------------------------------------------------------------------
    // Configuration factory

    /**
     * Create the theme configuration. The object will be created and configuration files will be parsed.
     *
     * @param array $mapping   The mapping between configuration files and classes. Some default values are provided and
     *                         the parameter will be merged with the default mappings.
     *
     * @return Configuration The configuration object
     */
    public static function create($mapping = array())
    {
        $defaultMapping = array(
            'image-sizes'    => self::DEFAULT_INITIALIZER_NS . '\ImageSizes',
            'widget-areas'   => self::DEFAULT_INITIALIZER_NS . '\WidgetAreas',
            'menu-locations' => self::DEFAULT_INITIALIZER_NS . '\MenuLocations',
            'theme-supports' => self::DEFAULT_INITIALIZER_NS . '\ThemeSupports'
        );

        $finalMapping = array_merge($defaultMapping, $mapping);

        return new Configuration($finalMapping);
    }

    /** @var array Array of Initializer objects */
    protected $initializers = array();

    /**
     * Hidden constructor. Use Configuration::setup
     *
     * @param array $mapping The mapping between configuration files and classes.
     *
     * @throws ConfigurationNotFoundException
     */
    protected function __construct($mapping)
    {
        // Supported parsers for configuration files
        $parsers = array(
            'config.php' => new PhpParser()
        );

        // Parse each file
        foreach ($mapping as $file => $className)
        {
            $fullPath = Paths::configuration($file);
            $data = null;

            /** @var \Baobab\Configuration\Parser\Parser $parser */
            foreach ($parsers as $ext => $parser)
            {
                if (file_exists($fullPath . '.' . $ext))
                {
                    $data = $parser->parse($fullPath);
                    break;
                }
            }

            if ($data == null)
            {
                throw new ConfigurationNotFoundException($file);
            }

            $this->initializers[$file] = new $className($data);
        }
    }

    /**
     * Apply the configuration
     */
    public function apply()
    {
        foreach ($this->initializers as $id => $initializer)
        {
            $initializer->run();
        }
    }
}