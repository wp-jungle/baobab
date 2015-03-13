<?php

namespace Baobab\Configuration\Parser;

interface Parser
{

    /**
     * Parse the configuration file and store the configuration data
     *
     * @param string $path The path to the configuration file
     *
     * @return array An associative array of configuration id/value pairs
     */
    public function parse($path);

}