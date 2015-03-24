<?php

namespace Baobab\Configuration\Initializer;

use Baobab\Configuration\Exception\UnknownSettingException;
use Baobab\Helper\Hooks;
use Baobab\Helper\Strings;

abstract class AbstractInitializer implements Initializer
{
    protected $data = array();
    protected $id = null;

    /**
     * Constructor
     *
     * @param string $id   The ID of the initializer
     * @param array  $data The configuration key/value pairs
     */
    public function __construct($id, $data)
    {
        $this->id = $id;
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Apply the data to configure the theme
     */
    public function run()
    {
        // Does nothing by default
    }

    /**
     * Get the value of a setting in the initializer configuration. If that setting is not found, an exception will be
     * thrown.
     *
     * @param string $key The key of the setting we are interested about
     *
     * @return mixed The setting value
     */
    public function getSettingOrThrow($key)
    {
        if ( !isset($this->data[$key]))
        {
            throw new UnknownSettingException($this->id, $key);
        }

        return $this->data[$key];
    }

    /**
     * Get the value of a setting in the initializer configuration. If that setting is not found, return the provided
     * default value.
     *
     * @param string $key          The key of the setting we are interested about
     * @param mixed  $defaultValue The default value to return if not found
     *
     * @return mixed The setting value or the default value
     */
    public function getSetting($key, $defaultValue)
    {
        if ( !isset($this->data[$key]))
        {
            return $defaultValue;
        }

        return $this->data[$key];
    }
}