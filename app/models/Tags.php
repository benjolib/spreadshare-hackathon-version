<?php

namespace DS\Model;

use DS\Constants\Paging;
use DS\Model\Events\TagsEvents;

/**
 * Tags
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
class Tags extends TagsEvents
{
    /**
     * @param array $ids
     * @param int   $limit
     *
     * @return array
     */
    public function getByIds(array $ids = [], $limit = Paging::endlessScrollPortions)
    {
        if (count($ids)) {
            return self::query()
                       ->columns(
                           [
                               self::class . ".id",
                               self::class . ".title",
                           ]
                       )
                       ->inWhere(self::class . '.id', $ids)
                       ->limit((int) $limit)
                       ->execute()
                       ->toArray() ?: [];
        }
        
        return [];
    }
}
