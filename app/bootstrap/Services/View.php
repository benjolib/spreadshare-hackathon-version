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
                            $volt = new \DS\Component\View\Volt\VoltAdapter($view, $di, $application);

                            $compiler = $volt->getCompiler();

                            $compiler->addFilter(
                                'truncate',
                                function ($str, $maxLen = 35, $suffix = '...') {
                                    return 'DS\Model\Tools::truncate(' . $str . ')';
                                }
                            );

                            $compiler->addFilter(
                                'round',
                                function ($number, $decimalPlaces = 0) {
                                    return 'DS\Model\Tools::round(' . $number . ')';
                                }
                            );
                            
                            $compiler->addFilter(
                                'ucfirst',
                                function ($string) {
                                    return 'DS\Model\Tools::ucfirst(' . $string . ')';
                                }
                            );

                            $compiler->addFilter(
                                'split',
                                function ($str, $delimiter) {
                                    return 'DS\Model\Tools::split(' . $str . ')';
                                }
                            );

                            return $volt;
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
