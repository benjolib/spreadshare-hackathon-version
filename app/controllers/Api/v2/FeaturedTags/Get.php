<?php

namespace DS\Controller\Api\v2\FeaturedTags;

use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Records;
use DS\Controller\Api\MethodInterface;
use DS\Model\Tables;
use DS\Model\Tags;

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
        $result = new Records(Tags::find(['columns'=>['id', 'title','featured'],'order'=>'id ASC'])->toArray());
        return $result;
    }
    
}
