<?php

use Aws\S3\S3Client;
use League\Flysystem\Adapter\Local;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Cached\CachedAdapter;
use League\Flysystem\Cached\Storage\Memory as CacheStore;
use League\Flysystem\Filesystem;

/**
 * Spreadshare
 *
 * Flysystem Initialization
 *
 * @package DS
 * @version $Version$
 */
return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di) {
    /**
     * Setup Flysystem Adapter
     *
     * @return
     */
    $di->set(
        'files',
        function () use ($application, $di) {
            $config = $application->getConfig();
            
            // Create the cache store
            $cacheStore = new CacheStore();
            
            if ($config['files']['type'] === 'aws')
            {
                $client  = new S3Client($config['files']['aws']);
                $adapter = new AwsS3Adapter($client, $config['files']['aws']['bucket']);
            }
            else
            {
                $adapter = new Local($config['files']['local']['path']);
            }
            
            // Decorate the adapter
            $adapter = new CachedAdapter($adapter, $cacheStore);
            
            return new Filesystem($adapter);
        }
    );
    
};
