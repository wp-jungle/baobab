<?php

namespace Baobab\Configuration\Exception;

    /**
     * Thrown when a configuration file was not found
     */
class ConfigurationNotFoundException extends \RuntimeException
{
    /**
     * Constructor.
     *
     * @param string $file The name of the file that was not found
     */
    public function __construct($file)
    {
        parent::__construct(sprintf('The file "%s" does not exist or is not recognized as a configuration file that can be parsed', $file));
    }
}
