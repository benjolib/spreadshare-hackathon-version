<?php

namespace DS;

use DS\Cli\Interaction\Output;
use DS\Component\ServiceManager;
use DS\Constants\Services;
use DS\Interfaces\GeneralApplication;
use Phalcon\Cli\Console;
use Phalcon\Config;
use Phalcon\DiInterface;
use Phalcon\Exception;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream as StreamAdapter;

/**
 * Spreadshare Application
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
final class CliApplication
    extends Console
    implements GeneralApplication
{
    /**
     * @var int
     */
    protected $argc = 0;
    
    /**
     * @var array
     */
    protected $argv = [];
    
    /**
     * @var string
     */
    private $task = '';
    
    /**
     * @var string
     */
    private $action = '';
    
    /**
     * @var array
     */
    private $params = [];
    
    /**
     * @var array
     */
    private $flags = [];
    
    /**
     * @var Logger\Multiple
     */
    private $logger = null;
    
    /**
     * @var Config
     */
    private $config = null;
    
    /**
     * @var bool
     */
    private $debug = true;
    
    /**
     * @var string
     */
    private $rootDirectory = '';
    
    /**
     * @var CliApplication
     */
    private static $instance = null;
    
    /**
     * @var ServiceManager
     */
    private $serviceManager = null;
    
    /**
     * @return string
     */
    public function getRootDirectory()
    {
        return $this->rootDirectory;
    }
    
    /**
     * @return \Phalcon\Config
     */
    public function getConfig()
    {
        return $this->config;
    }
    
    /**
     * @return ServiceManager
     */
    public function getServiceManager(): ServiceManager
    {
        return $this->serviceManager;
    }
    
    /**
     * @param ServiceManager $serviceManager
     *
     * @return $this
     */
    public function setServiceManager($serviceManager)
    {
        $this->serviceManager = $serviceManager;
        
        return $this;
    }
    
    /**
     * @param DiInterface $di
     * @param Config      $config
     *
     * @return CliApplication
     * @throws Exception
     */
    public static function initialize(DiInterface $di): CliApplication
    {
        if (!self::$instance)
        {
            self::$instance = new self($di);
        }
        
        /**
         * Initialize all required services
         *
         * @since Phalcon 3.0
         * @note  needed to change from ServiceManager::initialize() to a non static context because phalcon 3.0
         *        changed the way service closures are bound to an object
         * @see   https://github.com/phalcon/cphalcon/issues/11029#issuecomment-200612702
         */
        $servMan = ServiceManager::instance($di)->initialize(self::$instance, ['Router', 'Response']);
        
        self::$instance->setServiceManager($servMan);
        self::$instance->logger = $servMan->getCliLogger();
        self::$instance->logger->push(new StreamAdapter('php://stdout'));
        
        /**
         * Active sentry bug tracking
         */
        if (self::$instance->getConfig()['mode'] !== 'development')
        {
            $servMan->getRavenClient();
        }
        
        return self::instance();
    }
    
    /**
     * @return bool
     */
    public function isDebug()
    {
        return $this->debug;
    }
    
    /**
     * @param bool $debug
     *
     * @return $this
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
        
        return $this;
    }
    
    /**
     * @return CliApplication
     * @throws Exception
     */
    public static function instance()
    {
        if (!self::$instance)
        {
            throw new Exception('Cli Application is not initialized, yet.');
        }
        
        return self::$instance;
    }
    
    /**
     * @return Logger\Multiple
     */
    public function getLogger()
    {
        return $this->logger;
    }
    
    /**
     * Set Application arguments
     *
     * @param array
     * @param int
     */
    public function setArgs($argv, $argc)
    {
        $this->argv = $argv;
        $this->argc = $argc;
    }
    
    /**
     * Get the task/action to direct to
     *
     * @param array $flags cli arguments to determine tasks/action/param
     *
     * @throws Exception
     */
    protected function determineTask($flags)
    {
        if (is_array($flags))
        {
            // Since first argument is the name so script executing (pop it off the list)
            array_shift($flags);
            
            if (is_array($flags) && !empty($flags))
            {
                foreach ($flags as $flag)
                {
                    if ($this->isParameter($flag))
                    {
                        $param = explode('=', str_replace('--', '', $flag));
                        if (isset($param[1]))
                        {
                            $this->params[$param[0]] = $param[1];
                        }
                    }
                    elseif ($this->isFlag($flag))
                    {
                        $this->flags[] = substr($flag, 1);
                    }
                    elseif (empty($this->task))
                    {
                        $this->task = $flag;
                    }
                    elseif (empty($this->action))
                    {
                        $this->action = $flag;
                    }
                }
            }
            else
            {
                throw new Exception('Unable to determine task/action/params');
            }
        }
        else
        {
            throw new \InvalidArgumentException('flags has to be of type array!');
        }
    }
    
    /**
     * Determine if argument is a special flag
     *
     * @param string
     *
     * @return bool
     */
    protected function isFlag($flag)
    {
        return substr(trim($flag), 0, 1) == '-';
    }
    
    /**
     * Determine if argument is a special flag
     *
     * @param string
     *
     * @return bool
     */
    protected function isParameter($flag)
    {
        return substr(trim($flag), 0, 2) == '--' && strpos($flag, '=') > 0;
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
     * Print usage screen
     */
    private function usage()
    {
        $output = new Output();
        
        $output
            ->writeln("<Error>Invalid Usage:</Error>")
            ->writeln(" <Note>php</Note> cli/cli.php taskName")
            ->writeln('');
        
        $commandsPath = APP_PATH . 'tasks/';
        $directory    = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($commandsPath, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        
        $output->writeln("Possible tasknames are:");
        foreach ($directory as $object)
        {
            if (strstr($object->getFileName(), 'Task'))
            {
                $task = str_replace(['.php', 'Task'], '', $object->getFileName());
                
                $output->writeln(' <Comment>' . $task . '</Comment>');
            }
        }
    }
    
    /**
     * Run Task
     */
    public function run()
    {
        try
        {
            
            if ($debugKey = array_search('--debug', $this->argv))
            {
                $this->setDebug(true);
                register_shutdown_function([new \Phalcon\Debug(), 'display']);
                
                unset($this->argv[$debugKey]);
            }
            
            $exit = 0;
            
            if ($this->argc === 1)
            {
                $this->usage();
                
                return 1;
            }
            
            $this->determineTask($this->argv);
            
            $args = [];
            
            if (!$this->task)
            {
                $this->task = 'Main';
            }
            
            // Setup args (task, action, params) for console
            $args['task']   = "DS\\Task\\" . $this->task;
            $args['action'] = !empty($this->action) ? $this->action : 'main';
            $args['params'] = $this->params;
            $args['flags']  = $this->flags;
            
            // Kick off Task
            $this->handle($args);
            
        }
        catch (\Exception $e)
        {
            $exit = 1;
            
            echo $e->getMessage();
        }
        
        return $exit;
    }
    
    /**
     * @param DiInterface $di
     */
    public function __construct(DiInterface $di)
    {
        parent::__construct($di);
        
        $this->rootDirectory = dirname(__DIR__) . '/';
        $this->config        = $di[Services::CONFIG];
    }
}
