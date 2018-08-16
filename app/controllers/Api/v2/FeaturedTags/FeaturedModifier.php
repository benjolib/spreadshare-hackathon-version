<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 22/06/18
 * Time: 15:10
 */

namespace DS\Controller\Api\v2\FeaturedTags;

use DS\Controller\Api\Meta\Record;
use DS\Exceptions\InvalidParameterException;
use DS\Model\DataSource\UserRoles;
use DS\Model\Tables;
use DS\Model\Tags;


trait FeaturedModifier
{
    /**
     * @param $featured
     * @return Record
     * @throws InvalidParameterException
     */
    public function setFeatured($featured): Record
    {
        $tagId = $this->action;

        if (!$this->getServiceManager()->getAuth()->hasRole(UserRoles::Admin)) {
            throw new InvalidParameterException('Not allowed');
        }
        if (!isset($tagId)) {
            throw new InvalidParameterException('Invalid post package sent.');
        }

        if ($tagId > 0) {
            $tagModel = Tags::findFirstById($tagId);
            if (!$tagModel) {
                throw new InvalidParameterException('The table that you want to feature does not exist.');
            }

            $ok = $tagModel->setFeatured($featured)->save();
            if (!$ok) {
                var_dump($tagModel->getMessages());
                die();

            }
        }
        return new Record();
    }
}
