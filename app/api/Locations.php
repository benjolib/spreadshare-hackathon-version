<?php

namespace DS\Api;

use DS\Model\Cities;
use DS\Model\Locations as LocationsModel;

/**
 * Spreadshare
 *
 * Some default events
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
class Locations
    extends BaseApi
{
    /**
     * Return all locations
     *
     * @return array
     */
    public static function getAll(): array
    {
        self::generateLocationsFromCities();
        $locations = new LocationsModel;
        
        return $locations->find()->toArray();
    }
    
    /**
     * Generates all locations from cities
     *
     * This should only be called if there were new cities added to the database.
     */
    public static function generateLocationsFromCities()
    {
        $cities = new Cities();
        foreach ($cities->find() as $city)
        {
            if (!LocationsModel::findByFieldValue('locationName', $city->getCity()))
            {
                (new LocationsModel)
                    ->setLocationName($city->getCity())
                    ->setLat($city->getLat())
                    ->setLng($city->getLng())
                    ->setCityId($city->getId())
                    ->save();
            }
            
            if (!LocationsModel::findByFieldValue('locationName', $city->getCountry()))
            {
                (new LocationsModel)
                    ->setLocationName($city->getCountry())
                    ->setLat($city->getLat())
                    ->setLng($city->getLng())
                    ->save();
            }
            
        }
    }
}