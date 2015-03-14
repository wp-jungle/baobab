<?php

namespace Baobab\Theme\Exception;

/**
 * Thrown when the theme child class is not properly defined
 */
class ThemeDeclarationException extends \RuntimeException
{
    /**
     * Constructor.
     *
     * @param string $message The message to show
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
