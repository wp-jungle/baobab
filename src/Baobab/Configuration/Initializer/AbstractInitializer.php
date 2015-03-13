<?php

namespace Baobab\Configuration\Initializer;

use Baobab\Helper\Hooks;
use Baobab\Helper\Strings;

abstract class AbstractInitializer implements Initializer
{
    protected $data = array();

    /**
     * Constructor
     *
     * @param array $data The configuration key/value pairs
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

}