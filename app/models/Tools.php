<?php

namespace DS\Model;

/**
 * Tags
 *
 * @author    Stanley Day
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static truncate(string $str, int $maxLen = 35, string $suffix = '...')
 */
class Tools
{
    /**
     * @param string $str
     * @param int   $maxLen
     * @param int   $suffix
     *
     * @return string $str
     */
    public function truncate($str, $maxLen = 30, $suffix = '...')
    {
        if (strlen($str) > $maxLen) {
            $str = trim(substr($str, 0, $maxLen))."...";
        }
        return $str;
    }

    /**
     * @param float $number
     * @param int   $decimalPlaces
     *
     * @return float $number
     */
    public function round($number, $decimalPlaces = 0)
    {
        return round($number, $decimalPlaces);
    }

    /**
     * @param float $number
     * @param int   $decimalPlaces
     *
     * @return float $number
     */
    public function split($str, $delimiter)
    {
        return explode($delimiter, $str);
    }

    /**
     * @param string $data
     *
     * @return string $str
     */
    public function guidv4($data)
    {
        assert(strlen($data) == 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
