<?php

namespace DS\Model;

use DS\Model\Events\TableContributionsEvents;
use DS\Traits\Model\FindUserAndTableTrait;

/**
 * TableTokens
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
class TableContributions
    extends TableContributionsEvents
{
    use FindUserAndTableTrait;
    
}
