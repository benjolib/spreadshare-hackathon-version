<?php

namespace DS\Component\UserComponent;

use DS\Component\PrettyDateTime;
use Phalcon\Mvc\User\Component;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component
 */
class StringFormat extends Component
{
    /**
     * @var PrettyDateTime
     */
    private $date = null;
    
    /**
     * @return $this
     */
    public function init()
    {
        if (!$this->date)
        {
            $this->date = new PrettyDateTime();
        }
        
        return $this;
    }
    
    /**
     * @return StringFormat
     */
    public static function factory()
    {
        return (new self())->init();
    }
    
    /**
     * @param $date
     *
     * @return string
     * @throws \Exception
     */
    public function prettyDay(string $date)
    {
        return $this->date->day(new \DateTime($date));
    }
    
    /**
     * @param string $date
     *
     * @return string
     * @throws \Exception
     */
    public function prettyDate(string $date)
    {
        return $this->date->parse(new \DateTime($date));
    }
    
    /**
     * @param int $timestamp
     *
     * @return string
     * @throws \Exception
     */
    public function prettyDateTimestamp(int $timestamp)
    {
        return $this->date->parse(new \DateTime(date('Y-m-d H:i:s', $timestamp)));
    }
    
    /**
     * @param     $string
     * @param int $characters
     *
     * @return string
     */
    public function truncate($string, $characters = 0)
    {
        if ($characters > 0)
        {
            if (strlen($string) > $characters)
            {
                return substr($string, 0, $characters) . '..';
            }
        }
        
        return $string;
    }
}
