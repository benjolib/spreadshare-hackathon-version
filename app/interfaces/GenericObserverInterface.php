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
interface GenericObserverInterface
{
    /**
     * Call update function
     *
     * @param mixed $data
     *
     * @return mixed|void
     */
    public function update($data);
}
