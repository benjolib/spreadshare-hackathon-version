<?php

namespace DS\Controller\Api\v3\Bundles;

use DS\Exceptions\InvalidParameterException;
use DS\Model\DataSource\UserRoles;
use DS\Model\Bundles;
use DS\Model\BundleTags;

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
trait BundleModifier
{
    /**
     * Set/Clear curator role of a user
     *
     * @param bool $add
     * @return Record
     * @throws InvalidParameterException
     */
    public function updateBundle(Bundles $bundle, $params): Bundles
    {
        if (!$this->getServiceManager()->getAuth()->hasRole(UserRoles::Admin)) {
            throw new InvalidParameterException('Not allowed');
        }
        $bundle->setTitle(isset($params['title']) ? $params['title'] : null);
        $bundle->setImage('/path/to/image');

        if ($bundle->save()) {
            $bundleTags = new BundleTags();
            $bundleTags->setBundleId($bundle->getId());
            $bundleTags->assignTags(isset($params['tags']) ? $params['tags'] : null);
        } else {
            var_dump($bundle->getMessages());
            die();
        }

        return $bundle;
    }
}
