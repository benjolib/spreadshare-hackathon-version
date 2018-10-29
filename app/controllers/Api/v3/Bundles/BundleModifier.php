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

        if (!is_array($params)) {
            // Nothing to do here
            return $bundle;
        }

        $modified = false;

        if (array_key_exists('title', $params)) {
            // We have title provided
            $bundle->setTitle(isset($params['title']) ? $params['title'] : null);
            $modified = true;
        }

        if (array_key_exists('image', $params)) {
            // We have image bin data specified
            $image = isset($params['image']) ? base64_decode($params['image']) : null;
            $imageURI = null;

            // Save and set image
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
            $modified = true;
        }

        if (array_key_exists('featured', $params)) {
            // We have featured specified
            $bundle->setFeatured(isset($params['featured']) ? (int)$params['featured'] : 0);
            $modified = true;
        }

        // Save Bundle
        if ($modified) {
            if (!$bundle->save()) {
                die($bundle->getMessages());
            }
        }

        // Looks like bundle saved successfully

        // Process assigned tags
        if (array_key_exists('tags', $params)) {
            $bundleTags = new BundleTags();
            $bundleTags->setBundleId($bundle->getId());
            $bundleTags->assignTags(isset($params['tags']) ? $params['tags'] : null);
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
