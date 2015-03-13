<?php

namespace Baobab\Configuration\Exception;

    /**
     * Thrown when a file was not found
     *
     * @author Bernhard Schussek <bschussek@gmail.com>
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
