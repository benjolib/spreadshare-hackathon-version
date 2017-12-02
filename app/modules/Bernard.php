<?php

namespace DS\Modules;

use Bernard\Message\PlainMessage;
use Bernard\Producer;
use Bernard\Consumer;
use Bernard\QueueFactory\PersistentFactory;
use Bernard\Serializer;
use Bernard\Driver\PredisDriver;
use Bernard\Router\SimpleRouter;
use Predis\Client;

use Symfony\Component\EventDispatcher\EventDispatcher;
use DS\Component\ServiceManager;



/**
 * Spreadshare
 *
 * Use to connect to bernard
 *
 * @author    Rohan Dey
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Modules\Bernard
 */
class Bernard
{



  /**
   * Add  job to producer
   * @param  [String] $name
   * @param  [Array] $data
   * @return [void]
   */
  public static function produce($name, $data){


    $predis = ServiceManager::instance()->getDI()->get('predis');

    $driver = new PredisDriver($predis);

    $factory = new PersistentFactory($driver, new Serializer());

    $producer = new Producer($factory, new EventDispatcher());

    $message = new PlainMessage($name, $data);

    $producer->produce($message);

  }



  /**
   * Add  job to producer
   * @param  [String] $name
   * @param  [Class] $instance
   * @return [void]
   */
  public static function consume($name,$instance){


    $predis = ServiceManager::instance()->getDI()->get('predis');

    $driver = new PredisDriver($predis);

    $queues = new PersistentFactory($driver, new Serializer());

    $router = new SimpleRouter();

    $router->add($name, $instance);

    $consumer = new Consumer($router, new EventDispatcher());

    $consumer->consume($queues->create(self::camel2dashed($name)));

  }


  public static function camel2dashed($className) {
    return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $className));
  }



}
