<?php

namespace Baobab\Configuration\Parser;

use Baobab\Exception\FileNotFoundException;

class PhpParser implements Parser
{

    /**
     * Parse a configuration file in the PHP format (a return statement with an array)
     *
     * @param string $path The path to the file
     *
     * @return array The array of configuration parameters
     */
    public function parse($path)
    {
        $fullPath = strstr($path, '.config.php') ? $path : $path . '.config.php';
        if (!file_exists($fullPath))
        {
            throw new FileNotFoundException($fullPath);
        }

        return include($fullPath);
    }
}