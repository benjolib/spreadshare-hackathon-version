<?php
namespace DS\Model\DataSource;

use DS\Traits\Singleton;

/**
 *
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model\DataSource
 */
class ErrorCodes
{
    use Singleton;

    /**
     * Error codes
     */
    const GeneralException = 100;
    const SessionExpired = 110;
    const ApiError = 120;
    const InvalidParameter = 130;
    const UserValidation = 140;
    const ProfileViewsReached = 150;

    /**
     * @var array
     */
    private $codes = [
        self::SessionExpired => 'Session Expired',
        self::ApiError => 'Api Error',
        self::GeneralException => 'General Exception',
        self::InvalidParameter => 'Invalid Parameter',
    ];

    /**
     * @return array
     */
    public function getCodes()
    {
        return $this->codes;
    }
}
