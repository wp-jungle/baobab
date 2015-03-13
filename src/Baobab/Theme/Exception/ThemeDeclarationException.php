<?php

namespace Baobab\Theme\Exception;

    /**
     * Thrown when a file was not found
     *
     * @author Bernhard Schussek <bschussek@gmail.com>
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
