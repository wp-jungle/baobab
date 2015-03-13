<?php

namespace Baobab\Helper;

class Hooks
{

    /**
     * @see function add_action
     *
     * @param string $hook              The name of the action to which the $function_to_add is hooked.
     * @param mixed  $object            The object instance
     * @param string $method            The name of the method you wish to be called on the object.
     * @param int    $priority          Optional. Used to specify the order in which the functions
     *                                  associated with a particular action are executed. Default 10.
     *                                  Lower numbers correspond with earlier execution,
     *                                  and functions with the same priority are executed
     *                                  in the order in which they were added to the action.
     * @param int    $acceptedArgs      Optional. The number of arguments the function accept. Default 1.
     *
     * @return bool|void
     */
    public static function action($hook, $object, $method, $priority = 10, $acceptedArgs = 1)
    {
        return add_action($hook, array($object, $method), $priority, $acceptedArgs);
    }

    /**
     * @see function add_action
     *
     * @param string $hook              The name of the action to which the $function_to_add is hooked.
     * @param string $function          The name of the $function you wish to be called.
     * @param int    $priority          Optional. Used to specify the order in which the functions
     *                                  associated with a particular action are executed. Default 10.
     *                                  Lower numbers correspond with earlier execution,
     *                                  and functions with the same priority are executed
     *                                  in the order in which they were added to the action.
     * @param int    $acceptedArgs      Optional. The number of arguments the function accept. Default 1.
     *
     * @return bool|void
     */
    public static function actionMethod($hook, $function, $priority = 10, $acceptedArgs = 1)
    {
        return add_action($hook, $function, $priority, $acceptedArgs);
    }

    /**
     * @see function add_filter
     *
     * @param string $hook              The name of the action to which the $function_to_add is hooked.
     * @param mixed  $object            The object instance
     * @param string $method            The name of the method you wish to be called on the object.
     * @param int    $priority          Optional. Used to specify the order in which the functions
     *                                  associated with a particular action are executed. Default 10.
     *                                  Lower numbers correspond with earlier execution,
     *                                  and functions with the same priority are executed
     *                                  in the order in which they were added to the action.
     * @param int    $acceptedArgs      Optional. The number of arguments the function accept. Default 1.
     *
     * @return bool|void
     */
    public static function filter($hook, $object, $method, $priority = 10, $acceptedArgs = 1)
    {
        return add_filter($hook, array($object, $method), $priority, $acceptedArgs);
    }

    /**
     * @see function add_filter
     *
     * @param string $hook              The name of the action to which the $function_to_add is hooked.
     * @param string $function          The name of the $function you wish to be called.
     * @param int    $priority          Optional. Used to specify the order in which the functions
     *                                  associated with a particular action are executed. Default 10.
     *                                  Lower numbers correspond with earlier execution,
     *                                  and functions with the same priority are executed
     *                                  in the order in which they were added to the action.
     * @param int    $acceptedArgs      Optional. The number of arguments the function accept. Default 1.
     *
     * @return bool|void
     */
    public static function filterMethod($hook, $function, $priority = 10, $acceptedArgs = 1)
    {
        return add_filter($hook, $function, $priority, $acceptedArgs);
    }
}