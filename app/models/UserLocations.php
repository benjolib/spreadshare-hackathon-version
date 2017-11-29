<?php

namespace DS\Model;

use DS\Model\Events\UserLocationsEvents;

/**
 * UserLocations
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
class UserLocations
    extends UserLocationsEvents
{
    
    /**
     * Reassign all location ids
     *
     * @param int   $userId
     * @param array $locationIds
     *
     * @return $this
     */
    public function setUserLocationsByUserId(int $userId, array $locationIds): UserLocations
    {
        // Remove all locations
        $this->getWriteConnection()
             ->delete($this->getSource(), "userId = '{$userId}'");
        
        // .. and recrete them:
        foreach ($locationIds as $id)
        {
            (new self())->setUserId($userId)->setLocationId($id)->create();
        }
        
        return $this;
    }
    
    /**
     * @param int $userId
     *
     * @return array
     */
    public static function getUserLocations(int $userId): array
    {
        $query = self::query()
                     ->columns(
                         [
                             Locations::class . ".id",
                             Locations::class . ".locationName",
                         ]
                     )
                     ->innerJoin(Locations::class, self::class . '.locationId = ' . Locations::class . '.id')
                     ->where(UserLocations::class . '.userId = ?0', [$userId])
                     ->orderBy(Locations::class . ".locationName ASC");
        
        return $query->execute()->toArray() ?: [];
    }
}
