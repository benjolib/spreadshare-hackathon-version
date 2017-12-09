<?php

namespace DS\Component;

use DS\Component\Elasticsearch\ElasticaClient;
use DS\Interfaces\GeneralApplication;
use Phalcon\Di;
use Phalcon\Http\Response\Cookies;
use Phalcon\Security;

/**
 * Spreadshare
 *
 * ServiceManager: Registers all services lying under app/bootstrap/Services.
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component
 *
 * @method \Phalcon\Logger\Adapter\File getLogger()
 * @method \Phalcon\Logger\Adapter\File getErrorLogger()
 * @method \Phalcon\Logger\Multiple getCliLogger()
 * @method \DS\Component\Auth getAuth()
 * @method \Phalcon\Queue\Beanstalk\Extended getBeanstalk()
 * @method \DS\Component\Cache\Memcache getMemcache()
 * @method \DS\Component\Cache\Redis getRedis()
 * @method \Phalcon\Http\Request getRequest()
 * @method \Phalcon\Mvc\Model\MetaData\Redis getModelsMetaData()
 * @method \DS\Model\Manager\CachedReusableModelsManager getModelsManager()
 * @method \Phalcon\Crypt getCrypt()
 * @method \Phalcon\Db\Adapter\Pdo\Mysql getReadDatabase()
 * @method \Phalcon\Db\Adapter\Pdo\Mysql getWriteDatabase()
 * @method \Phalcon\Db\Profiler getProfiler()
 * @method \Phalcon\Cache\BackendInterface getModelsCache()
 * @method \DS\Component\Intl getIntl()
 * @method \DS\Component\Queue\Beanstalk\BeanstalkQueue getQueue()
 * @method \Phalcon\Http\Response getResponse()
 * @method \Phalcon\Mvc\Router getRouter()
 * @method \Phalcon\Session\AdapterInterface getSession()
 * @method \Phalcon\Mvc\Model\Transaction\Manager getTransactions()
 * @method \Phalcon\Mvc\Url getUrl()
 * @method \Phalcon\Mvc\View getView()
 * @method ElasticaClient getElasticSearch();
 * @method \Raven_Client getRavenClient();
 * @method Notify getNotify();
 * @method \League\Flysystem\Filesystem getFiles();
 * @method Security getSecurity();
 * @method Cookies getCookies();
 * @method \Maknz\Slack\Client getSlack();
 * @method \DS\Component\Wallet\WalletApi getWalletApi();
 */
class ServiceManager
{
    /**
     * Service Directory
     *
     * @var string
     */
    public static $serviceDir = 'bootstrap/Services';
    
    /**
     * @var ServiceManager
     */
    private static $instance;
    
    /**
     * @var Di
     */
    protected $di;
    
    /**
     * Sets the dependency injector
     *
     * @param Di $dependencyInjector
     */
    public function setDI(\Phalcon\DiInterface $dependencyInjector)
    {
        $this->di = $dependencyInjector;
        
        return $this;
    }
    
    /**
     * Returns the internal dependency injector
     *
     * @return Di
     */
    public function getDI()
    {
        return $this->di;
    }
    
    /**
     * @param Di|null $dependencyInjector
     *
     * @return ServiceManager
     */
    public static function instance(Di $dependencyInjector = null): ServiceManager
    {
        if (!self::$instance)
        {
            self::$instance = new self($dependencyInjector);
        }
        
        return self::$instance;
    }
    
    /**
     * Initialize all relevant DI services
     *
     * @return $this
     */
    public function initialize(GeneralApplication $application, $excludeServices = [])
    {
        $di = $this->getDI();
        
        $directory = __DIR__ . '/../' . self::$serviceDir . '/';
        
        if ($dirhandle = opendir($directory))
        {
            
            while (($file = readdir($dirhandle)) !== false)
            {
                if (in_array(str_replace('.php', '', $file), $excludeServices))
                {
                    continue;
                }
                
                if (is_file($directory . $file) && strpos($file, '.') !== 0)
                {
                    // Registering server "$file"
                    $return = include_once $directory . $file;
                    
                    if (is_callable($return))
                    {
                        // Register service
                        $return ($application, $di);
                    }
                    // else: Service is registered elsewhere
                }
            }
        }
        
        return $this;
    }
    
    /**
     * Route all calls to dependency injector
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->getDI()->__call($name, $arguments);
    }
    
    /**
     * DiInjection constructor.
     *
     * @param Di|\Phalcon\DiInterface $dependencyInjector
     */
    public function __construct(Di $dependencyInjector = null)
    {
        if ($dependencyInjector)
        {
            $this->di = $dependencyInjector;
        }
        else
        {
            $this->di = Di::getDefault();
        }
    }
}
