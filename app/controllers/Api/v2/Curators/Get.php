<?php

namespace DS\Controller\Api\v2\Curators;

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
    private $searchMinimum = 2;

    /**
     * @return bool
     */
    public function needsLogin()
    {
        return true;
    }
    
    public function process()
    {
        $query = $this->request->get('q', null, null);

        if ($query === null || strlen($query) < $this->searchMinimum)
        {
            throw new \InvalidArgumentException(sprintf('Give at least %d characters.', $this->searchMinimum));
        }

        $result = new Records(User::searchCuratorsByName($query, 50));
        return $result;
    }
}
