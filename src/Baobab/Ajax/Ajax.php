<?php

namespace Baobab\Ajax;

use Baobab\Helper\Hooks;

/**
 * Class Ajax
 * @package Baobab\Ajax
 *
 *          The main class for our Ajax utilities. Can be accessed via the main facade: Baobab::ajax()
 */
class Ajax
{

    /** @var string The namespace to use for our ajax variables */
    private $namespace;

    /**
     * Constructor
     *
     * @param string $namespace The namespace to use for our ajax variables
     */
    function __construct($namespace)
    {
        $this->namespace = $namespace;

        if (is_admin())
        {
            Hooks::action('admin_head', $this, 'printGlobalAjaxObject');
        }
        else
        {
            Hooks::action('wp_head', $this, 'printGlobalAjaxObject');
        }
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Print the Ajax global variable in the <head> tag.
     *
     * @return void
     * @ignore
     */
    public function printGlobalAjaxObject()
    {
        // Get all the variables we may need for our Ajax calls
        $globalData = apply_filters('baobab/ajax/global_data', array(
            'ajaxUrl' => admin_url('admin-ajax.php')
        ));

        // Build a list of all these variables as key/value pairs
        $objectTokens = array();
        $jsonFlags = version_compare(PHP_VERSION, '5.4.0', '>=') ? JSON_UNESCAPED_SLASHES : 0;
        foreach ($globalData as $key => $value)
        {
            $objectTokens[] = "    " . $key . ": " . json_encode($value, $jsonFlags);
        }

        // Build our script
        $output = "<script type=\"text/javascript\">\n\r";
        $output .= "  //<![CDATA[\n\r";
        $output .= "  var " . $this->namespace . " = {\n\r";
        $output .= join(",\n\r", $objectTokens);
        $output .= "\n\r";
        $output .= "  };\n\r";
        $output .= "  //]]>\n\r";
        $output .= "</script>";

        // Output the global data
        echo($output);
    }

    /**
     * Get the HTML hidden field to print in your form to protect it
     *
     * @param string $action The ajax action you are referring to
     *
     * @return string The HTML code to print in your form
     */
    public function generateNonceField($action)
    {
        $nonceName = $this->namespace . '_' . $action;

        return wp_nonce_field(md5($nonceName), $nonceName, true, false);
    }

    /**
     * Check that we have proper nonce value in our form data
     *
     * @param string $action   The ajax action we have protected
     */
    public function checkAjaxReferrer($action)
    {
        $nonceName = $this->namespace . '_' . $action;
        check_ajax_referer(md5($nonceName), $nonceName);
    }

}