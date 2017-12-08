<?php

namespace DS\Model;

use DS\Constants\Paging;
use DS\Model\Events\TableStaffPicksEvents;
use DS\Model\Events\TableTokensEvents;
use DS\Traits\Model\FindUserAndRowTrait;
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
class TableStaffPicks
    extends TableStaffPicksEvents
{

}
