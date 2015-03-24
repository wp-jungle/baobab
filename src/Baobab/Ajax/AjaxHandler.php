<?php

namespace Baobab\Ajax;

use Baobab\Facade\Baobab;
use Baobab\Helper\Hooks;

/**
 * Class AjaxHandler
 * @package Baobab\Ajax
 *
 *          Class that simplifies creating ajax handlers
 */
abstract class AjaxHandler
{
    /** @var string This must be defined by child classes! */
    // public static $ACTION = 'null';

    /**
     * @var  string Valid values: guest|logged|any. Specifies when our ajax callback will be available (for logged
     *              in users only, for guest users only or for both)
     */
    protected $accessType;

    /**
     * Constructor
     *
     * @param string $accessType Valid values: guest|logged|any. Specifies when our ajax callback will be available
     *                           (for logged in users only, for guest users only or for both)
     */
    public function __construct($accessType)
    {
        $this->accessType = $accessType;

        $this->registerHooks();
    }

    /**
     * Child classes should implement this function to indicate which variables they want to expose globally. You don't
     * need to expose the ajaxUrl, as this is anyway added.
     *
     * @return array|null The variables to expose in our global namespace ajax object
     */
    protected function getGlobalVariables() { return null; }

    /**
     * Child classes should implement this function to actually process the ajax request
     */
    protected abstract function processRequest();

    /**
     * Callback attached to the WP hook. This basically calls the child class's processRequest method after checking
     * the ajax referrer for safety purposes
     */
    public function doAjax()
    {
        self::checkAjaxReferrer();

        $this->processRequest();
    }

    /**
     * Hook into WordPress to execute our ajax callback
     */
    protected function registerHooks()
    {
        // Our callbacks are registered only on the admin side even for guest and frontend callbacks
        if (is_admin())
        {
            switch ($this->accessType)
            {
                case 'guest':
                    Hooks::action('wp_ajax_nopriv_' . static::$ACTION, $this, 'doAjax');
                    break;

                case 'logged':
                    Hooks::action('wp_ajax_' . static::$ACTION, $this, 'doAjax');
                    break;

                case 'any':
                    Hooks::action('wp_ajax_nopriv_' . static::$ACTION, $this, 'doAjax');
                    Hooks::action('wp_ajax_' . static::$ACTION, $this, 'doAjax');
                    break;

                default:
                    throw new \InvalidArgumentException("Invalid value for the Ajax access type parameter: "
                        . $this->accessType);
            }
        }

        // If we have global variables
        Hooks::filter('baobab/ajax/global_data', $this, 'addGlobalVariables');
    }

    /**
     * Add our variables to the global namespace object
     *
     * @param array $vars The current variables
     *
     * @return array The original variables + our own stuff
     */
    public function addGlobalVariables($vars)
    {
        $globalVars = $this->getGlobalVariables();
        if ($globalVars == null || empty($globalVars))
        {
            return $vars;
        }

        return array_merge($vars, $this->getGlobalVariables());
    }

    /**
     * Get the HTML hidden field to print in your form to protect it
     *
     * @return string The HTML code to print in your form
     */
    public static function generateNonceField()
    {
        return Baobab::ajax()->generateNonceField(static::$ACTION);
    }

    /**
     * Check that we have proper nonce value in our form data
     */
    public static function checkAjaxReferrer()
    {
        Baobab::ajax()->checkAjaxReferrer(static::$ACTION);
    }
}