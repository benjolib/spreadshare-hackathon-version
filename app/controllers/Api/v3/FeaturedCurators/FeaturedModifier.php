<?php

namespace DS\Controller\Api\v3\FeaturedCurators;

use DS\Controller\Api\Meta\Record;
use DS\Exceptions\InvalidParameterException;
use DS\Model\DataSource\UserRoles;
use DS\Model\User;

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
     * Set/Clear featured flag
     *
     * @param bool $add
     * @return Record
     * @throws InvalidParameterException
     */
    public function setFeatured(bool $add): Record
    {
        $userId = $this->id;

        if (!$this->getServiceManager()->getAuth()->hasRole(UserRoles::Admin)) {
            throw new InvalidParameterException('Not allowed');
        }
        if (!isset($userId)) {
            throw new InvalidParameterException('Invalid post package sent.');
        }

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
        return new Record();
    }
}
