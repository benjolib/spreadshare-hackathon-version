<?php

namespace DS\Component\Phql;

use DS\Traits\Singleton;
use Phalcon\Db\Dialect\MysqlExtended;

/**
 * Spreadshare
 *
 * Queueing
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component\Mail
 */
class SqlDialect extends MysqlExtended
{
    use Singleton;
}
