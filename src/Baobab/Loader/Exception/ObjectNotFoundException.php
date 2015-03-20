<?php

namespace Baobab\Loader\Exception;

/**
 * Class ObjectNotFoundException
 * @package Baobab\Loader\Exception
 *
 * Thrown when an object was not found in the registry
 */
class ObjectNotFoundException extends \RuntimeException
{
    /**
     * Constructor.
     *
     * @param string $nickname The nickname of the object that was not found
     */
    public function __construct($nickname)
    {
        parent::__construct(sprintf('The object "%s" has not been loaded in the registry', $nickname));
    }
}
