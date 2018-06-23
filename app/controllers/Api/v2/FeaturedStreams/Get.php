<?php

namespace DS\Controller\Api\v2\FeaturedStreams;

use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Records;
use DS\Controller\Api\MethodInterface;
use DS\Model\Tables;

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
        return false;
    }
    
    public function process()
    {
        /** @var Tables[] $streams */
        $streams = Tables::find(['order' => 'id ASC']);
        foreach ($streams as $stream) {
            $result[] = array_merge($stream->toArray(['id','title', 'tagline']), ['featured'=> $stream->isFeatured()]);
        }
        return new Records($result);
    }
    
}
