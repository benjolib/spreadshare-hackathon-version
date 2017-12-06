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
        echo "This is the default queue task and the default action";
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
            echo "Command line argument event name is required example --name=touchTable \r\n";
            
            return;
        }
        
        Bernard::consume($name, new ElasticSearchListener);
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
            echo "Command line argument event name is required example --name=newWallet \r\n";
            
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
