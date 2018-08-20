<?php

namespace DS\Controller\Api\v3\FeaturedTags;

use DS\Controller\Api\Meta\Record;
use DS\Exceptions\InvalidParameterException;
use DS\Model\DataSource\UserRoles;
use DS\Model\Tags;


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
        $tagId = $this->id;

        if (!$this->getServiceManager()->getAuth()->hasRole(UserRoles::Admin)) {
            throw new InvalidParameterException('Not allowed');
        }
        if (!isset($tagId)) {
            throw new InvalidParameterException('Invalid post package sent.');
        }

        $tagModel = Tags::findFirstById($tagId);
        if (!$tagModel) {
            throw new InvalidParameterException('The table that you want to feature does not exist.');
        }

        if (!$tagModel->setFeatured($featured)->save()) {
            var_dump($tagModel->getMessages());
            die();

        }

        return new Record();
    }
}
