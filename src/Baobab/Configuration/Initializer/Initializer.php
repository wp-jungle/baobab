<?php

namespace Baobab\Configuration\Initializer;

interface Initializer
{

    /**
     * Apply the data to configure the theme
     */
    public function run();

    /**
     * Get the value of a setting in the initializer configuration. If that setting is not found, an exception will be
     * thrown.
     *
     * @param string $key The key of the setting we are interested about
     *
     * @return mixed The setting value
     */
    public function getSettingOrThrow($key);

    /**
     * Get the value of a setting in the initializer configuration. If that setting is not found, return the provided
     * default value.
     *
     * @param string $key          The key of the setting we are interested about
     * @param mixed  $defaultValue The default value to return if not found
     *
     * @return mixed The setting value or the default value
     */
    public function getSetting($key, $defaultValue);
}