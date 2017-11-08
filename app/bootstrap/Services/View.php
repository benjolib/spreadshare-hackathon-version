<?php
/**
 * Spreadshare
 *
 * URL Service Initialization
 *
 * @package DS
 * @version $Version$
 */

return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di) {
    $di->set(
        'view',
        function () use ($application, $di) {
            $view = new \Phalcon\Mvc\View();
            
            $view->setViewsDir($application->getRootDirectory() . 'app/views/');
            $view->registerEngines(
                [
                    ".volt" =>
                        function (\Phalcon\Mvc\View $view, $di) use ($application) {
                            return new \DS\Component\View\Volt\VoltAdapter($view, $di, $application);
                        },
                ]
            );
            
            return $view;
            
        }
    );
    
    /*
    use Phalcon\Cache\Frontend\Output as OutputFrontend;
    use Phalcon\Cache\Backend\Memcache as MemcacheBackend;
    
    // Set the views cache service
    $di->set(
        'viewCache',
        function () {
            // Cache data for one day by default
            $frontCache = new OutputFrontend(
                [
                    'lifetime' => 86400,
                ]
            );
    
            // Memcached connection settings
            $cache = new MemcacheBackend(
                $frontCache,
                [
                    'host' => 'localhost',
                    'port' => '11211',
                ]
            );
    
            return $cache;
        }
    );
    */
    
};