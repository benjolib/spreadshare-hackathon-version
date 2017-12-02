<?php

namespace DS\Model;

use DS\Model\Events\UserStatsEvents;
use DS\Traits\Model\UserStatsTrait;

/**
 * UserStats
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
class UserStats
    extends UserStatsEvents
{
    use UserStatsTrait;
}
