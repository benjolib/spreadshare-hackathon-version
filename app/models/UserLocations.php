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
             ->delete($this->getSource(), 'userId = ?', [$userId]);
        
        // .. and recrete them:
        foreach ($locationIds as $id)
        {
            (new self())->setUserId($userId)->setLocationId($id)->create();
        }
        
        return $this;
    }
}
