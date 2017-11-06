<?php

namespace DS\Task;

use DS\Cli\Interaction\Input;
use DS\Cli\Interaction\Output;
use DS\CliApplication;
use DS\Component\ServiceManager;
use Phalcon\Cli\Task;

/**
 * Spreadshare
 *
 * GrabFeeds Task
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 */
abstract class Base
    extends Task
{
    
    /**
     * The command name
     *
     * @var string
     */
    protected $name;
    
    /**
     * The command description
     *
     * @var string
     */
    protected $description;
    
    /**
     * @var Output
     */
    protected $output;
    
    /**
     * @var Input
     */
    protected $input;
    
    /**
     * @var CliApplication
     */
    protected $app;
    
    /**
     * @var ServiceManager
     */
    protected $service;
    
    /**
     * @param string $text
     * @param bool   $newline
     *
     * @return $this
     */
    public function debugOutput($text, $newline = false): Base
    {
        if ($this->app->isDebug())
        {
            if ($newline)
            {
                $this->getOutput()->writeln($text);
            }
            else
            {
                $this->getOutput()->write($text);
            }
        }
        else
        {
            $this->logger->debug($text);
        }
        
        return $this;
    }
    
    /**
     * Returns the output instance
     *
     * @return Output
     */
    public function getOutput(): Output
    {
        return $this->output;
    }
    
    /**
     * Returns the input instance
     *
     * @return Input
     */
    public function getInput(): Input
    {
        return $this->input;
    }
    
    /**
     * Initialize task
     */
    public function initialize()
    {
        $this->logger = $this->getDI()->get('logger');
        $this->input  = new Input();
        $this->output = new Output();
        
        $this->app     = CliApplication::instance();
        $this->service = $this->app->getServiceManager();
    }
}
