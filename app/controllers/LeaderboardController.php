<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;
use DS\Model\UserStats;
use DS\Model\Wallet;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
class LeaderboardController
    extends BaseController
    implements LoginAwareController
{
    /**
     * @return bool
     */
    public function needsLogin()
    {
        return true;
    }
    
    /**
     * Table
     */
    public function indexAction($tab = 'tokens')
    {
        switch ($tab)
        {
            case 'contributions':
                $orderBy = UserStats::class . '.contributionsCount';
                break;
            case 'follower':
                $orderBy = UserStats::class . '.followerCount';
                break;
            case 'upvotes':
                $orderBy = UserStats::class . '.upvotesCount';
                break;
            default:
            case 'tokens':
                $orderBy = Wallet::class . '.tokens';
                break;
        }
        
        $this->view->setVar('users', UserStats::getLeaderboard($orderBy, 100));
        
        $this->view->setVar('tab', $tab);
        $this->view->setMainView('leaderboard/leaderboard');
    }
}
