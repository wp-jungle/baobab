<?php

namespace Baobab\Configuration\Exception;

/**
 * Class UnknownSettingException
 * @package Baobab\Configuration\Exception
 *
 * Thrown when a configuration setting was not found
 */
class UnknownSettingException extends \RuntimeException
{
    /**
     * Constructor.
     *
     * @param string $section The name of the section file
     * @param string $key     The key of the setting
     */
    public function __construct($section, $key)
    {
        parent::__construct(sprintf('The setting "%s" has not been loaded in the section "%s"', $key, $section));
    }
}
