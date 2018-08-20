<?php

namespace DS\Controller\Api\v3\FeaturedCurators;

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
 * @author            Vladislav Klimenko
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

    /**
     * @return Records
     */
    public function process()
    {
        /** @var User[] $curators */
        $curators = User::findByRole( UserRoles::Curator);
        foreach ($curators as $curator) {
            $result[] = array_merge($curator->toArray(['id', 'name']), ['featured' => $curator->isFeaturedCurator()]);
        }
        return new Records($result);
    }
}
