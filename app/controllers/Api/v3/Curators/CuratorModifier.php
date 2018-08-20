<?php

namespace DS\Controller\Api\v3\Curators;

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
trait CuratorModifier
{
    /**
     * Set/Clear curator role of a user
     *
     * @param bool $add
     * @return Record
     * @throws InvalidParameterException
     */
    public function setCurator(bool $add): Record
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
            $ok = $userModel->addRole(UserRoles::Curator)->save();
        } else {
            $ok = $userModel->removeRole(UserRoles::Curator)->save();
        }
        if (!$ok) {
            var_dump($userModel->getMessages());
            die();

        }
        return new Record();
    }
}
