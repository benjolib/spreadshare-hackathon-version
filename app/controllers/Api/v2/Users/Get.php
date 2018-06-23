<?php

namespace DS\Controller\Api\v2\Users;

use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Records;
use DS\Controller\Api\MethodInterface;
use DS\Model\DataSource\UserRoles;
use DS\Model\Tables;
use DS\Model\User;

/**
 *
 * Spreadshare
 *
 * @author            Dennis Stücken
 * @license           proprietary
 * @copyright         Spreadshare
 * @link              https://www.spreadshare.co
 *
 * @version           $Version$
 * @package           DS\Controller
 *
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
    
    public function process()
    {
        /** @var User[] $curators */
        $curators = User::find( );
        foreach ($curators as $curator) {
            $result[] = array_merge($curator->toArray(['id', 'name']), ['curator' => $curator->isCurator()]);
        }
        return new Records($result);
    }
}
