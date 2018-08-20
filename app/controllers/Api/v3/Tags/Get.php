<?php

namespace DS\Controller\Api\v3\Tags;

use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Records;
use DS\Controller\Api\MethodInterface;

use DS\Api\Tags;

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
     * @var int Need at least this chars num provided as needle for a search
     */
    private $searchMinimumChars = 2;
    
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
        $query = $this->request->get('q', null, null);
        
        if ($query === null || strlen($query) < $this->searchMinimumChars) {
            throw new \InvalidArgumentException(sprintf('Give at least %d characters.', $this->searchMinimumChars));
        }

        $result = new Records(Tags::newSearchByName($query, 50));
        return $result;
    }
}
