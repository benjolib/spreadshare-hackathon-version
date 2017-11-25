<?php

namespace DS\Api;

use DS\Model\Tags as TagsModel;
use DS\Traits\Api\GetAllTrait;

/**
 * Spreadshare
 *
 * General Tags Api
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
class Tags
    extends BaseApi
{
    use GetAllTrait;
    
    /**
     * Modelclass is used in GetAllTrait
     *
     * @var string
     */
    private static $modelClass = 'Tags';
    
    /**
     * Searches a location by name. Wildcard is added at the end of $name.
     *
     * @param     $name
     * @param int $limit
     *
     * @return array
     */
    public static function searchByName($name, $limit = 100)
    {
        $locations = new TagsModel;
        
        return $locations->find(
            [
                "conditions" => "title LIKE ?0",
                'columns' => self::$defaultColumns,
                "order" => "title ASC",
                "limit" => $limit,
                "bind" => [$name . '%'],
            ]
        )->toArray(['id', 'locationName']);
    }
    
}