<?php

namespace DS\Task;

use DS\Listeners\ElasticSearch as ElasticSearchListener;
use DS\Listeners\Wallet as WalletListener;
use DS\Modules\Bernard;
use DS\Task\TaskHelpers\LoggerTrait;

/**
 * Spreadshare
 *
 * Main Task
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 */
class NewQueueTask extends Base
{
    use LoggerTrait;
    
    public function mainAction()
    {
        echo "This is the default queue task and the default action" . PHP_EOL;
        echo "Please use NewQueue table or NewQueue wallet." . PHP_EOL;
    }
    
    /**
     * table queue
     *
     * @param array $input ['name'] ['touchTable']
     */
    public function tableAction($input)
    {
        
        $name = $input['name'];
        
        if (!$name)
        {
            echo "Command line argument event name is required example --name=touchTable" . PHP_EOL;
            
            return;
        }
        
        $listener = new ElasticSearchListener('tables', 'table');
        
        echo "Reindexing.." . PHP_EOL;
        echo "Reindexed {$listener->reindex()} documents." . PHP_EOL;
        
        echo "Running while loop..." . PHP_EOL;
        Bernard::consume($name, $listener);
    }
    
    /**
     * wallet task
     *
     * @param array $input ['newWallet']
     */
    public function walletAction($input)
    {
        $name = $input['name'];
        
        if (!$name)
        {
            echo "Command line argument event name is required example --name=newWallet" . PHP_EOL;
            
            return;
        }
        
        Bernard::consume($name, new WalletListener);
    }
    
    /**
     * MainTask initialization.
     */
    public function initialize()
    {
        parent::initialize();
    }
}
