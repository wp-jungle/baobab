<?php

namespace Baobab\Exception;

/**
 * Thrown when a file was not found
 */
class FileNotFoundException extends \RuntimeException
{
    /**
     * Constructor.
     *
     * @param string $path The path to the file that was not found
     */
    public function __construct($path)
    {
        parent::__construct(sprintf('The file "%s" does not exist', $path));
    }
}
