<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 22/06/18
 * Time: 15:05
 */

namespace DS\Controller\Api\v2\Users;


use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\MethodInterface;

class Delete extends ActionHandler implements MethodInterface
{
    use CuratorModifier;

    public function needsLogin()
    {
        return true;
    }

    public function process()
    {
        return $this->setCurator(false);
    }
}