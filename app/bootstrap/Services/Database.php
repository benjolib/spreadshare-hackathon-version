<?php
/**
 * Spreadshare
 *
 * DB Service Initialization
 *
 * @package DS
 * @version $Version$
 */
use Phalcon\Cache\Backend\Memcache as BackendMemcache;
use Phalcon\Cache\Backend\Redis as BackendRedis;
use Phalcon\Cache\Frontend\Data as FrontendData;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use DS\Component\Phql\SqlDialects\GroupConcatDialect as GroupConcatDialect;

/**
 * @param \DS\Interfaces\GeneralApplication $application
 * @param \Phalcon\Di\FactoryDefault        $di
 */
return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di)
{
    $config = $application->getConfig();
    
    $dialect                                  = GroupConcatDialect::register();
    /** @noinspection PhpIllegalStringOffsetInspection */
    $config['read-database']['dialectClass']  = $dialect;
    /** @noinspection PhpIllegalStringOffsetInspection */
    $config['write-database']['dialectClass'] = $dialect;
    
    // Set the database services
    $di['read-database']  = function () use ($config)
    {
        return new DbAdapter(
            (array) $config['read-database']
        );
    };
    $di['write-database'] = function () use ($config)
    {
        return new DbAdapter(
            (array) $config['write-database']
        );
    };
    $di['db'] = $di['write-database'];
    
    // Ignore unknown columns to prevent unexpected error messages,
    // as seen on github issue https://github.com/phalcon/cphalcon/issues/1652
    // \Phalcon\Mvc\Model::setup(['ignoreUnknownColumns' => true]);

    #ifdef DEBUG
    /** @noinspection PhpIllegalStringOffsetInspection */
    if ($config['read-database']['profile'])
    {
        $di->set(
            'profiler',
            function () use ($di)
            {
                return new \Phalcon\Db\Profiler();
            }
        );

        /**
         * @var $profiler \Phalcon\Db\Profiler
         */
        $profiler = $di->get('profiler');

        $eventsManager = new EventsManager();
        $eventsManager->attach(
            'db',
            function (Event $event, \Phalcon\Db\Adapter $connection) use ($profiler, $di)
            {
                if ($event->getType() == 'beforeQuery')
                {
                    // Start a profile with the active connection
                    $profiler->startProfile($connection->getSQLStatement());
                }

                if ($event->getType() == 'afterQuery')
                {
                    // Stop the active profile
                    $profiler->stopProfile();

                    $profile = $profiler->getLastProfile();

                    $profileLog = "SQL Statement: " . $profile->getSQLStatement() . " (".str_replace("\n", "", var_export($connection->getSqlVariables(), true)).") ==> ";
                    $profileLog .= "Time: " . $profile->getTotalElapsedSeconds();

                    $di->get(\DS\Constants\Services::LOGGER)->log($profileLog, \Phalcon\Logger::DEBUG);
                }
            }
        );

        $di->get('read-database')->setEventsManager($eventsManager);
        $di->get('write-database')->setEventsManager($eventsManager);
    }

    #endif

    // Set the models cache service
    $di->set(
        'modelsCache',
        function () use ($config)
        {

            // Cache data for one day by default
            $frontCache = new FrontendData(
                [
                    "lifetime" => 86400,
                ]
            );

            if ($config->get('redis'))
            {
                $cache = new BackendRedis(
                    $frontCache,
                    (array) $config['redis']
                );
            }
            else
            {
                // Memcached connection settings
                $cache = new BackendMemcache(
                    $frontCache,
                    $config['memcache'][0]->toArray()
                );
            }

            $cache->flush();

            return $cache;
        }
    );
};
