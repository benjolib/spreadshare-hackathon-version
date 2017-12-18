<?php

namespace DS\Model\Helper;

use DS\Traits\Factory;

/**
 * Spreadshare
 *
 * DateRange model
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 */
class DateRange
{
    use Factory;
    
    /**
     * @var int
     */
    private $from;
    
    /**
     * @var int
     */
    private $to;
    
    /**
     * @return int
     */
    public function getFrom(): int
    {
        return $this->from;
    }
    
    /**
     * @param int $from
     *
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = $from;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getTo(): int
    {
        return $this->to;
    }
    
    /**
     * @param int $to
     *
     * @return $this
     */
    public function setTo($to)
    {
        $this->to = $to;
        
        return $this;
    }
    
    /**
     * Today range
     *
     * @return DateRange
     */
    public static function initToday(): DateRange
    {
        $timestamp = strtotime('today');
        
        return self::factory()
                   ->setFrom($timestamp)
                   ->setTo($timestamp + 86399);
    }
    
    /**
     * Yesterday range
     *
     * @return DateRange
     */
    public static function initYesterday(): DateRange
    {
        $timestamp = strtotime('yesterday');
        
        return self::factory()
                   ->setFrom($timestamp)
                   ->setTo($timestamp + 86399);
    }
    
    /**
     * this week (monday-sunday) range
     *
     * @return DateRange
     */
    public static function initThisWeek(): DateRange
    {
        $timestamp = strtotime('this week');
        
        return self::factory()
                   ->setFrom($timestamp)
                   ->setTo($timestamp + 604799);
    }
    
    /**
     * last week (monday-sunday) range
     *
     * @return DateRange
     */
    public static function initLastWeek(): DateRange
    {
        $timestamp = strtotime('last week');
        
        return self::factory()
                   ->setFrom($timestamp)
                   ->setTo($timestamp + 1209599);
    }
    
    /**
     * This month (01.-30/31.) range
     *
     * @return DateRange
     */
    public static function initThisMonth(): DateRange
    {
        $timestamp = strtotime('this month');
        
        return self::factory()
                   ->setFrom($timestamp)
                   ->setTo($timestamp + 37497599);
    }
    
    /**
     * Last month (01.-30/31.) range
     *
     * @return DateRange
     */
    public static function initLastMonth(): DateRange
    {
        $timestamp = strtotime('last month');
        
        return self::factory()
                   ->setFrom($timestamp)
                   ->setTo($timestamp + 37497599);
    }
    
    /**
     * Days to today range
     *
     * @return DateRange
     */
    public static function initLastDays(int $days): DateRange
    {
        $timestamp = strtotime('-' . $days . ' days');
        
        return self::factory()
                   ->setFrom($timestamp)
                   ->setTo($timestamp + ($days * 86400) - 1);
    }

    /**
     * Days to today range
     *
     * @return DateRange
     */
    public static function initDayFromTodayBackwards(int $day): DateRange
    {
        $timestamp = strtotime('-' . $day . ' days');

        return self::factory()
                   ->setFrom($timestamp)
                   ->setTo($timestamp + 86400 - 1);
    }
    
    /**
     * Init last year 01.01-31.12
     *
     * @return DateRange
     */
    public static function initLastYear(): DateRange
    {
        return self::factory()
                   ->setFrom(strtotime('01/01 last year'))
                   ->setTo(strtotime('12/31 23:59:59 last year'));
    }
    
    /**
     * DateRange constructor.
     *
     * @param int $from
     * @param int $to
     */
    public function __construct(int $from = 0, int $to = 0)
    {
        $this->from = $from;
        $this->to   = $to;
    }
}