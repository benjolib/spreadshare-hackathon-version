<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 22/06/18
 * Time: 15:10
 */

namespace DS\Controller\Api\v2\FeaturedCurators;

use DS\Controller\Api\Meta\Record;
use DS\Exceptions\InvalidParameterException;
use DS\Model\DataSource\UserRoles;
use DS\Model\User;


trait FeaturedModifier
{
    /**
     * Set/Clear featured flag
     *
     * @param bool $add
     * @return Record
     * @throws InvalidParameterException
     */
    public function setFeatured(bool $add): Record
    {
        $userId = $this->action;

        if (!$this->getServiceManager()->getAuth()->hasRole(UserRoles::Admin)) {
            throw new InvalidParameterException('Not allowed');
        }
        if (!isset($userId)) {
            throw new InvalidParameterException('Invalid post package sent.');
        }

        if ($userId > 0) {
            $userModel = User::findFirstById($userId);
            if (!$userModel) {
                throw new InvalidParameterException('The table that you want to feature does not exist.');
            }

            if ($add) {
                $ok = $userModel->addRole(UserRoles::FeaturedCurator)->save();
            } else {
                $ok = $userModel->removeRole(UserRoles::FeaturedCurator)->save();
            }
            if (!$ok) {
                var_dump($userModel->getMessages());
                die();

            }
        }
        return new Record();
    }
}
