<?php

namespace DS\Api;

use DS\Model\Topics as TopicsModel;

/**
 * Spreadshare
 *
 * General Locations Api
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
class Topics
    extends BaseApi
{
    /**
     * Default columns to use for response
     *
     * @var string
     */
    private static $defaultColumns = 'id, title';
    
    /**
     * Return all locations
     *
     * @return array
     */
    public static function getAll(): array
    {
        $locations = new TopicsModel;
        
        return $locations->find(
            [
                'columns' => self::$defaultColumns,
            ]
        )->toArray();
    }
}