<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 22/06/18
 * Time: 15:10
 */

namespace DS\Controller\Api\v2\FeaturedStreams;

use DS\Controller\Api\Meta\Record;
use DS\Model\Tables;


trait FeaturedModifier
{
    public function setFeatured($featured): Record
    {
        $tableId = $this->action;
        $user = $this->getServiceManager()->getAuth()->getUser();
        if (!$user->isAdmin()) {
            throw new \InvalidArgumentException('Not allowed');
        }
        if (!isset($tableId)) {
            throw new \InvalidArgumentException('Invalid post package sent.');
        }

        if ($tableId > 0) {
            $tableModel = Tables::findFirstById($tableId);
            if (!$tableModel) {
                throw new \InvalidArgumentException('The table that you want to feature does not exist.');
            }

            $ok = $tableModel->setFeatured($featured)->save();
            if (!$ok) {
                var_dump($tableModel->getMessages());
                die();

            }
        }
        return new Record();
    }

}