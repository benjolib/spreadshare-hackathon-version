<?php

namespace DS\Api;

use DS\Model\User;
use DS\Model\UserLocations;

/**
 * Spreadshare
 *
 * User Settings Api
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static findFirstById(int $id)
 */
class UserSettings
    extends BaseApi
{
    
    /**
     * @param int    $userId
     * @param string $imagePath
     * @param string $name
     * @param string $handle
     * @param string $tagline
     * @param array  $locationIds
     * @param string $website
     * @param bool   $showTokensOnProfilePage
     *
     * @return User
     */
    public function savePersonalSettings(int $userId, $imagePath, $name, $handle, $tagline, array $locationIds, $website, $showTokensOnProfilePage = true)
    {
        $user = User::get($userId);
        
        if (!$user->getId())
        {
            throw new \InvalidArgumentException('User id does not exist!');
        }
        
        if ($imagePath)
        {
            $user->setImage($imagePath);
        }
        
        $user->setName($name)
             ->setHandle($handle)
             ->setTagline($tagline)
             ->setWebsite($website);
        
        $user->save();
        
        if (count($locationIds))
        {
            (new UserLocations())->setUserLocationsByUserId($userId, $locationIds);
        }
        
        return $user;
    }
    
    /**
     * @param int    $userId
     * @param string $email
     * @param string $password
     *
     * @return User
     */
    public function saveAccountSettings(int $userId, string $email, string $password)
    {
        return User::findFirstById($userId)->saveCredentials($email, $password);
    }
}