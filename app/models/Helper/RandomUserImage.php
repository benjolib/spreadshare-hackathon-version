<?php

namespace DS\Model\Helper;

/**
 * Spreadshare
 *
 * Random Image Helper
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 */
class RandomUserImage
{
    
    /**
     * Returns a random default image
     *
     * @return string
     */
    public static function get(): string
    {
        $images = [
            '/assets/images/anakin.jpg',
            '/assets/images/dustin.jpg',
            '/assets/images/eleven.png',
            '/assets/images/jim_hopper.png',
            '/assets/images/lucas.png',
            '/assets/images/mike.png',
        ];
        
        return $images[rand(0, 5)];
    }
}