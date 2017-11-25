<?php

namespace DS\Api;

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
     * @var string
     */
    private static $modelClass = 'Tags';
}