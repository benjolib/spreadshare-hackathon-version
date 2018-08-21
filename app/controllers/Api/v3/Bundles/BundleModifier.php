<?php

namespace DS\Controller\Api\v3\Bundles;

use DS\Exceptions\InvalidParameterException;
use DS\Model\DataSource\UserRoles;
use DS\Model\Bundles;
use DS\Model\BundleTags;
use DS\Component\Image\Image;

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
        // set title
        $bundle->setTitle(isset($params['title']) ? $params['title'] : null);
        $image = isset($params['image']) ? base64_decode($params['image']) : null;
        $imageURI = null;

        // save and set image
        $ext = Image::getExtension($image);
        if ($ext) {
            // image type is recognized, all is fine
            $imageName = uniqid("", true).$ext;
            $imagePath = $this->getImageDiskPathByName($imageName);
            if (file_put_contents($imagePath, $image)) {
                // write ok
                $imageURI = $this->getImageURI($imageName);
            }
        }
        $bundle->setImage($imageURI);

        // save Bundle and all assigned tags
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

    /**
     * Get full image path on disk
     *
     * @param $imageName
     * @return string
     */
    public function getImageDiskPathByName($imageName)
    {
        return ROOT_PATH."public/bundleimages/$imageName";
    }

    /**
     * Get full image path on disk
     *
     * @param $imageName
     * @return string
     */
    public function getImageDiskPathByURI($imageURI)
    {
        return ROOT_PATH."public/$imageURI";
    }

    /**
     * Get image URI
     *
     * @param $imageName
     * @return string
     */
    public function getImageURI($imageName)
    {
        return "/bundleimages/$imageName";
    }
}
