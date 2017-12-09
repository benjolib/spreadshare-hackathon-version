<?php

namespace DS\Component\Mail\ViewParams;

use DS\Application;

/**
 * Spreadshare
 *
 * Mailing
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component\Mail
 */
class DefaultParams
{
    /**
     * @var string
     */
    public $headerMessage = '';
    
    /**
     * @var bool
     */
    public $showUnsubscribeLink = true;
    
    /**
     * @var string
     */
    public $topMessage = '';
    
    /**
     * @var string
     */
    public $bottomMessage = '';
    
    /**
     * @var string
     */
    public $buttonText = '';
    
    /**
     * @var string
     */
    public $buttonLink = '';
    
    /**
     * @var string
     */
    public $companyAddress = 'Schönholtzer Str. 10A, 10115 Berlin';
    
    /**
     * @var string
     */
    public $url = '';
    
    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
    
    /**
     * DefaultParams constructor.
     *
     * @throws \Phalcon\Exception
     */
    public function __construct()
    {
        $config = Application::instance()->getConfig();
        
        $this->url = 'http' . (serviceManager()->getRequest()->isSecure() ? 's' : '') . '://' . $config['domain'];
    }
}
