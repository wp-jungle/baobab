<?php

namespace Baobab\Loader\Exception;

/**
 * Class DuplicateObjectException
 * @package Baobab\Loader\Exception
 *
 * Thrown when an object was already in the registry for that nickname
 */
class DuplicateObjectException extends \RuntimeException
{
    /**
     * Constructor.
     *
     * @param string $nickname The nickname of the object that was not found
     */
    public function __construct($nickname)
    {
        parent::__construct(sprintf('The object with nickname "%s" has already been loaded in the registry', $nickname));
    }
}
