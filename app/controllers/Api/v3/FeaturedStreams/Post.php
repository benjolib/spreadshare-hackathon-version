<?php

namespace DS\Controller\Api\v3\FeaturedStreams;

use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\MethodInterface;

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
class Post extends ActionHandler implements MethodInterface
{
    use FeaturedModifier;

    /**
     * @return bool
     */
    public function needsLogin()
    {
        return true;
    }

    /**
     * @return \DS\Controller\Api\Meta\Record
     */
    public function process()
    {
        return $this->setFeatured(1);
    }
}
