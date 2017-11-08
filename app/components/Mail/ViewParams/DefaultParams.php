<?php
namespace DS\Component\Mail\ViewParams;

/**
 * Spreadshare
 *
 * Mailing
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
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
    public $companyAddress = 'Spreadshare.co';

    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}
