<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 22/06/18
 * Time: 15:10
 */

namespace DS\Controller\Api\v2\FeaturedStreams;

use DS\Controller\Api\Meta\Record;
use DS\Exceptions\InvalidParameterException;
use DS\Model\DataSource\UserRoles;
use DS\Model\Tables;


trait FeaturedModifier
{
    /**
     * @param $featured
     * @return Record
     * @throws InvalidParameterException
     */
    public function setFeatured($featured): Record
    {
        $tableId = $this->action;

        if (!$this->getServiceManager()->getAuth()->hasRole(UserRoles::Admin)) {
            throw new InvalidParameterException('Not allowed');
        }
        if (!isset($tableId)) {
            throw new InvalidParameterException('Invalid post package sent.');
        }

        if ($tableId > 0) {
            $tableModel = Tables::findFirstById($tableId);
            if (!$tableModel) {
                throw new InvalidParameterException('The table that you want to feature does not exist.');
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
