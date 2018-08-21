<?php

namespace DS\Controller\Api\v3\Curators;

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
     * @var int Need at least this chars num provided as needle for a search
     */
    private $searchMinimumChars = 2;

    /**
     * @return bool
     */
    public function needsLogin()
    {
        return true;
    }

    /**
     * @return Records
     */
    public function process()
    {
        $query = $this->request->get('q', null, null);

        if ($query === null || strlen($query) < $this->searchMinimumChars) {
            throw new \InvalidArgumentException(sprintf('Give at least %d characters.', $this->searchMinimumChars));
        }

        $result = new Records(User::searchCuratorsByName($query, 50));
        return $result;
    }
}
