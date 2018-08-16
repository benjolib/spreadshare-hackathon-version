<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 22/06/18
 * Time: 15:05
 */

namespace DS\Controller\Api\v2\FeaturedTags;


use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\MethodInterface;

class Delete extends ActionHandler implements MethodInterface
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
        return $this->setFeatured(0);
    }
}
