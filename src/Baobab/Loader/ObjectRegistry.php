<?php

namespace Baobab\Loader;

use Baobab\Loader\Exception\DuplicateObjectException;
use Baobab\Loader\Exception\ObjectNotFoundException;
use Composer\Autoload\ClassLoader;

/**
 * Class ObjectRegistry
 * @package Baobab\Loader
 *
 *          The registry that handles our class loading
 */
class ObjectRegistry
{
    /** @var array The classes that have been instanciated automatically */
    private $classLoader = null;

    /** @var array The classes that have been instanciated automatically */
    private $autoInstantiations = array();

    /**
     * Constructor
     *
     * @param ClassLoader $classLoader
     */
    public function __construct($classLoader)
    {
        $this->classLoader = $classLoader;
    }

    /**
     * Registers a set of PSR-4 directories for a given namespace,
     * appending to the ones previously set for this namespace.
     *
     * @param string       $prefix The prefix/namespace, with trailing '\\'
     * @param array|string $paths  The PSR-0 base directories
     *
     * @throws \InvalidArgumentException
     */
    public function addPsr4($prefix, $paths)
    {
        $this->classLoader->addPsr4($prefix, $paths);
    }

    /**
     * Add an instance of a class to the registry
     *
     * @param string $nickname The nickname for this object
     * @param mixed  $object   The object instance
     */
    public function register($nickname, $object)
    {
        if (isset($this->autoInstantiations[$nickname]))
        {
            throw new DuplicateObjectException($nickname);
        }

        $this->autoInstantiations[$nickname] = $object;
    }

    /**
     * Get an instance of a class from the registry
     *
     * @param string $nickname The nickname we gave it
     *
     * @return mixed
     */
    public function get($nickname)
    {
        if (isset($this->autoInstantiations[$nickname]))
        {
            return $this->autoInstantiations[$nickname];
        }

        return null;
    }

    /**
     * @param string $nickname The nickname we gave it
     *
     * @return mixed
     */
    public function getOrThrow($nickname)
    {
        if (isset($this->autoInstantiations[$nickname]))
        {
            return $this->autoInstantiations[$nickname];
        }

        throw new ObjectNotFoundException($nickname);
    }

}