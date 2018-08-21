<?php

namespace DS\Controller\Api\v3\FeaturedStreams;

use DS\Controller\Api\Meta\Record;
use DS\Exceptions\InvalidParameterException;
use DS\Model\DataSource\UserRoles;
use DS\Model\Tables;

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
trait FeaturedModifier
{
    /**
     * @param $featured
     * @return Record
     * @throws InvalidParameterException
     */
    public function setFeatured($featured): Record
    {
        $tableId = $this->id;

        if (!$this->getServiceManager()->getAuth()->hasRole(UserRoles::Admin)) {
            throw new InvalidParameterException('Not allowed');
        }
        if (!isset($tableId)) {
            throw new InvalidParameterException('Invalid post package sent.');
        }

        $tableModel = Tables::findFirstById($tableId);
        if (!$tableModel) {
            throw new InvalidParameterException('The table that you want to feature does not exist.');
        }

        if (!$tableModel->setFeatured($featured)->save()) {
            var_dump($tableModel->getMessages());
            die();
        }

        return new Record();
    }
}
