<?php

namespace Baobab\Configuration\Exception;

/**
 * Class UnknownSectionException
 * @package Baobab\Configuration\Exception
 *
 * Thrown when a configuration section was not found
 */
class UnknownSectionException extends \RuntimeException
{
    /**
     * Constructor.
     *
     * @param string $section The name of the section that was not found
     */
    public function __construct($section)
    {
        parent::__construct(sprintf('The section "%s" has not been loaded in the configuration', $section));
    }
}
