<?php

/**
 * Spreadshare
 *
 * AsstesManager Initialization
 *
 * @package DS
 * @version $Version$
 */
return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di) {
    /**
     * Register default caching via memcache
     */
    $di->set(
        \DS\Constants\Services::MEMCACHE,
        function () use ($application) {
            $config = $application->getConfig();
            
            if (!isset($config['memcache'])) {
                throw new \Phalcon\Exception('Error. Memcache service is used but there is no configuration.');
            }
            
            return new \DS\Component\Cache\Memcache(
                $config['memcache']->toArray(),
                'spreadshare.cache.'
            );
        }
    );
    
    /**
     * Register default caching via memcache
     */
    $di->set(
        \DS\Constants\Services::REDIS,
        function () use ($application) {
            $config = $application->getConfig();
            
            if (!isset($config['redis'])) {
                throw new \Phalcon\Exception('Error. Redis service is used but there is no configuration.');
            }
            
            return new \DS\Component\Cache\Redis(
                [
                    "lifetime" => 3600 * 48,
                    "prefix" => "spreadshare.cache.",
                    'host' => $config['redis']['host'],
                    'port' => $config['redis']['port'],
                ]
            );
        }
    );
    
    /**
     * Register custom cached model manager
     */
    /*
    $di->setShared(
        \DS\Constants\Services::MODELSMANAGER,
        function () use ($di)
        {
            return new CachedReusableModelsManager($di);
        }
    );
    */
    
    /**
     * Register model meta data caching
     */
    if ($application->getConfig()->mode !== 'development') {
        $di->set(
            \DS\Constants\Services::MODELSMETADATA,
            function () use ($application, $di) {
                $config = $application->getConfig();
                
                if ($config['redis']) {
                    $cache = new \Phalcon\Mvc\Model\MetaData\Redis(
                        [
                            "lifetime" => 86400 * 30,
                            "prefix" => "metadata.",
                            'host' => $config['redis']['host'],
                            'port' => $config['redis']['port'],
                        ]
                    );
                } else {
                    $cache = new \Phalcon\Mvc\Model\MetaData\Memcache(
                        [
                            "lifetime" => 86400 * 30,
                            "prefix" => "metadata.",
                            'host' => $config['memcache'][0]['host'],
                            'port' => $config['memcache'][0]['port'],
                        ]
                    );
                }
                
                return $cache;
            }
        );
    }
};
