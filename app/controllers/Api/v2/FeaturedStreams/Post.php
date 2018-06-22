<?php

namespace DS\Controller\Api\v2\FeaturedStreams;

use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Record;
use DS\Controller\Api\MethodInterface;
use DS\Model\Tables;

class Post extends ActionHandler implements MethodInterface
{
    /**
     * @return bool
     */
    public function needsLogin()
    {
        return true;
    }
    
    public function process()
    {
        $tableId = $this->action;
        $user  = $this->getServiceManager()->getAuth()->getUser();
        if (!$user->isAdmin()) {
            throw new \InvalidArgumentException('Not allowed');
        }
        if (!isset($tableId))
        {
            throw new \InvalidArgumentException('Invalid post package sent.');
        }

        if ($tableId > 0)
        {
            $tableModel = Tables::findFirstById($tableId);
            if (!$tableModel)
            {
                throw new \InvalidArgumentException('The table that you want to feature does not exist.');
            }

            $ok = $tableModel->setFeatured(1)->save();
            if (!$ok) {
                var_dump($tableModel->getMessages());die();

            }
        }
        return new Record();
    }
}
