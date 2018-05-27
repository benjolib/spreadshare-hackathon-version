<?php

namespace DS\Model;

use DS\Model\Events\UserConnectionsEvents;

/**
 * UserConnections
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
class UserConnections
    extends UserConnectionsEvents
{
    /**
     * @return array
     */
    public function getConnectionList()
    {
        //$vars = get_object_vars($this);
        //unset($vars[0];
        //return $vars;
        
        return [
            'twitter',
            'facebook',
            'medium',
            'dribbble',
            'behance',
            'github',
            'gitlab',
            'bitbucket',
            'slack',
            'angellist',
            'googleplus',
            'stackoverflow',
            'linkedin',
            'quora',
            'reddit',
            'ycombinator',
            'instagram',
            'visco',
            'soundcloud',
            'vsco',
            'fivehundretpx',
            'codepen',
            'producthunt',
            'discord',
            'raspberrypi',
            'periscope',
            'vimeo',
            'twitch',
            'patreon',
            'youtube',
            'bloglovin',
            'deviantart',
            'bandcamp',
        ];
    }

    public static function getAllConnections(int $userId)
    {
        return self::findAllByFieldValue('userId', $userId);
    }
}
