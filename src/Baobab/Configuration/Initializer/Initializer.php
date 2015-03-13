<?php

namespace Baobab\Configuration\Initializer;

interface Initializer {

    /**
     * Apply the data to configure the theme
     */
    public function run();

}