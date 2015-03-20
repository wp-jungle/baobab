<?php
namespace Baobab\Api;

use Baobab\Helper\Hooks;

/**
 * Class EndPoint
 * @package Baobab\Api
 *
 *          Makes it even easier to create end points in your theme
 *
 * @link    https://make.wordpress.org/plugins/2012/06/07/rewrite-endpoints-api/
 */
abstract class EndPoint
{

    /** @var string The name of the end point */
    protected $name;

    /** @var int The places where to add this endpoint */
    protected $places;

    /**
     * Constructor
     *
     * @param string $name   The name of the end point
     * @param int    $places The places where to add this endpoint. e.g. EP_YEAR | EP_DATE
     *
     * For the valid values for the $places argument, have a look at the EP_* constants defined in the
     * wp-includes/rewrite.php file.
     *
     * @link https://core.trac.wordpress.org/browser/trunk/src/wp-includes/rewrite.php
     */
    function __construct($name, $places)
    {
        $this->name = $name;
        $this->places = $places;

        $this->registerHooks();
    }

    /**
     * Child classes should implement this in order to process the end point request
     */
    protected abstract function handleEndPointRequest();

    /**
     * Register all hooks we may need
     */
    protected function registerHooks()
    {
        Hooks::action('init', $this, 'addEndPoint');
        Hooks::action('template_redirect', $this, 'onTemplateRedirect');
    }

    /**
     * Add the end point (init hook callback)
     */
    public function addEndPoint()
    {
        add_rewrite_endpoint($this->name, $this->places);
    }

    /**
     * Callback for the template_redirect hook. Will check if we need to handle a request for the end point.
     */
    public function onTemplateRedirect()
    {
        global $wp_query;
        if ( isset($wp_query->query_vars[$this->name]))
        {
            $this->handleEndPointRequest();
        }
    }


}