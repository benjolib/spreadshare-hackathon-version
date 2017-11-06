<?php

namespace DS\Traits;

use DS\Interfaces\GenericObserverInterface;

/**
 * Spreadshare Application
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
trait GenericObservableTrait
{
    /**
     * @var GenericObserverInterface[]
     */
    private $observers = [];
    
    /**
     * Attach new observer
     *
     * @param GenericObserverInterface $observer
     *
     * @return $this
     */
    public function attach(GenericObserverInterface $observer)
    {
        $this->observers[] = $observer;
        
        return $this;
    }
    
    /**
     * Notify all observers
     *
     * @param mixed $data
     */
    public function notify($data)
    {
        foreach ($this->observers as $observer)
        {
            $observer->update($data);
        }
    }
}
