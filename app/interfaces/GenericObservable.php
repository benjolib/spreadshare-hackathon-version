<?php
namespace DS\Interfaces;

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
interface GenericObservable
{
    /**
     * Attach new observer
     *
     * @param GenericObserverInterface $observer
     *
     * @return mixed
     */
    public function attach(GenericObserverInterface $observer);

    /**
     * Notify all observers
     *
     * @param mixed $data
     *
     * @return mixed
     */
    public function notify($data);
}
