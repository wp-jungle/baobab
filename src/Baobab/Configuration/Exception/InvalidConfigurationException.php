<?php

namespace Baobab\Configuration\Exception;

/**
 * Thrown when a configuration file has some invalid parameters
 */
class InvalidConfigurationException extends \RuntimeException
{
    /**
     * Constructor.
     *
     * @param string $class   The initializer class throwing the exception
     * @param string $setting The setting causing a problem
     */
    public function __construct($class, $setting)
    {
        parent::__construct(sprintf('Initializer %s has a missing or invalid setting: %s', $class, $setting));
    }
}
