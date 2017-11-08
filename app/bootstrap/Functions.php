<?php
/**
 * This file is used to define some service functions that will be enabled from within the views and everywhere else
 */

if (!function_exists('di'))
{
    /**
     * @param null $service
     *
     * @return \Phalcon\Di
     */
    function di($service = null)
    {
        $default = \Phalcon\Di::getDefault();
        
        if ($service !== null)
        {
            return $default->get($service);
        }
        
        return $default;
    }
}

if (!function_exists('auth'))
{
    /**
     * @return \DS\Component\Auth
     */
    function auth()
    {
        return di()->get('auth');
    }
}

if (!function_exists('serviceManager'))
{
    /**
     * @return \DS\Component\ServiceManager
     */
    function serviceManager()
    {
        return \DS\Component\ServiceManager::instance(di());
    }
}