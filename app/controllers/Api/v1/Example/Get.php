<?php
namespace DS\Controller\Api\v1\Example;

use DS\Application;
use DS\Component\ServiceManager;
use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Record;
use DS\Controller\Api\MethodInterface;
use DS\Exceptions\ApiException;
use DS\Exceptions\UserValidationException;
use DS\Model\DataSource\UserStatus;
use DS\Model\ReduxState\UserState;
use DS\Model\Subscription\Subscription;
use DS\Model\User;
use Firebase\JWT\JWT;
use Phalcon\Logger;

/**
 *
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
class Get extends ActionHandler implements MethodInterface
{
    /**
     * @return bool
     */
    public function needsLogin()
    {
        return false;
    }

    /**
     * Process Get Method
     *
     * @return mixed
     */
    public function process()
    {
        return new Record("It's working.");
    }

}
