<?php

namespace DS\Component;

use DS\Traits\DiInjection;

/**
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component
 */
class Notify
{
    use DiInjection;
    
    private static $counter = 0;
    
    /**
     * Send a notify message via HTTP Header X-Notify-$counter
     *
     * @param string $message
     */
    public function headerMessage(string $message)
    {
        $this->serviceManager->getResponse()->setHeader('X-Notify-' . self::$counter++, $message);
    }
    
}
