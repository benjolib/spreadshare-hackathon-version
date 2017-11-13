<?php

namespace DS\Api;

/**
 * Spreadshare
 *
 * Api Base
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
abstract class BaseApi
{
    /**
     * @var \DS\Component\ServiceManager
     */
    protected $serviceManager;
    
    /**
     * BaseApi constructor.
     */
    public function __construct()
    {
        $this->serviceManager = serviceManager();
    }
}