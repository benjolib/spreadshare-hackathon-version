<?php

namespace DS;

use DS\Component\Auth;
use DS\Component\ServiceManager;
use DS\Constants\Services;
use DS\Interfaces\GeneralApplication;
use Phalcon\Config;
use Phalcon\DiInterface;
use Phalcon\Exception;
use Phalcon\Http\Response\Cookies;
use Phalcon\Logger;
use Phalcon\Mvc\Application as PhalconApplication;

/**
 * Spreadshare Application
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
final class Application
    extends PhalconApplication
    implements GeneralApplication
{

    /**
     * @var Application
     */
    private static $instance = null;

    /**
     * @var string
     */
    public static $baseUri = '/';

    /**
     * @var
     */
    private $rootDirectory = '/';

    /**
     * @var \Phalcon\Config
     */
    private $config = null;

    /**
     * @var Logger\Adapter
     */
    private $logger = null;

    /**
     * Root directory with ending /
     *
     * @return string
     */
    public function getRootDirectory()
    {
        return $this->rootDirectory;
    }

    /**
     * Return current running mode.
     *
     * Can either be production, staging or development
     *
     * @return string
     */
    public function getMode()
    {
        return isset($this->config['mode']) ? $this->config['mode'] : 'production';
    }

    /**
     * @return \Phalcon\Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return Auth
     */
    public function getAuth()
    {
        return $this->di->get(Services::AUTH);
    }

    /**
     * @param DiInterface $di
     * @param Config      $config
     */
    public function __construct(DiInterface $di)
    {
        parent::__construct($di);

        $this->rootDirectory = dirname(__DIR__) . '/';
        $this->config        = $di[Services::CONFIG];

        /**
         * Listen for uncaught exceptions and hidden warnings
         */
        if ($this->getMode() === 'development')
        {
            $di->set(
                Services::DEBUG,
                function ()
                {
                    return (new \Phalcon\Debug())->listen()->listenExceptions()->listenLowSeverity();
                }
            );

            $di->get(Services::DEBUG);
        }
    }

    /**
     * @param DiInterface $di
     * @param Config      $config
     *
     * @return Application
     */
    public static function initialize(DiInterface $di)
    {
        if (!self::$instance)
        {
            self::$instance = new Application($di);
        }

        $di->set(Services::APPLICATION, self::$instance);

        self::$instance
            // Register services
            ->registerServices()
            // Do session management
            ->sessionManagement();

        return self::$instance;
    }

    /**
     * @return $this
     */
    public function sessionManagement()
    {
        // Initialize session by accessing auth from DI; This should stay here, otherwize the session will
        // start at the first ->loggedIn() call in the template, which is far too late
        ServiceManager::instance($this->getDI())->getAuth();

        return $this;
    }

    /**
     * @param     $message
     * @param int $type
     *
     * @return $this
     */
    public function log($message, $type = Logger::INFO)
    {
        $this->logger->log($message, $type);

        return $this;
    }

    /**
     * @return Application
     * @throws Exception
     */
    public static function instance()
    {
        if (!self::$instance)
        {
            throw new Exception('Application not initialized, yet.');
        }

        return self::$instance;
    }

    /**
     * Prevent cloning
     */
    final private function __clone()
    {
    }

    /**
     * Register DI Services
     *
     * @return $this
     */
    private function registerServices()
    {
        // Get base Uri
        self::$baseUri = $this->config['baseurl'];

        /**
         * Initialize all required services
         *
         * @since Phalcon 3.0
         * @note  needed to change from ServiceManager::initialize() to a non static context because phalcon 3.0
         *        changed the way service closures are bound to an object
         * @see   https://github.com/phalcon/cphalcon/issues/11029#issuecomment-200612702
         */
        $servMan = ServiceManager::instance($this->getDI())->initialize($this);

        // Set logger instance
        $this->logger = $servMan->getLogger();

        if ($this->getMode() === 'development')
        {
            if ($this->getDI()->has('whoops'))
            {
                /**
                 * @var $whoops \Whoops\Run
                 */
                $whoops = $this->getDI()->getShared('whoops');
                $logger = $this->getDI()->get(\DS\Constants\Services::ERRORLOGGER);
                $whoops
                    ->pushHandler(new \Whoops\Handler\JsonResponseHandler())
                    ->pushHandler(
                        function (\Exception $exception, $inspector, $run) use ($logger)
                        {
                            $logger->critical($exception->getMessage());
                            $logger->critical(json_encode($exception->getTrace()));
                        }
                    );
            }
        }
        else
        {
            $servMan->getRavenClient();
        }

        $this->di->set(
            Services::COOKIES,
            function ()
            {
                $cookies = new Cookies();
                $cookies->useEncryption(true);

                return $cookies;
            }
        );

        return $this;
    }

}
