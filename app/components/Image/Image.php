<?php

namespace DS\Component\Image;

use DS\Exceptions\FileNotFoundException;
use Phalcon\Exception;

/**
 * Spreadshare
 *
 * @author Vladislav Klimenko
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component\Image
 */
class Image
{
    /**
     * Check whether binary data is a known image type
     *
     * @param $bin
     * @return bool
     */
    public static function isKnownType($bin)
    {
        return self::isBmp($bin) || self::isGif($bin) || self::isJpeg($bin) || self::isPng($bin);
    }

    /**
     * Get file extension by image binary data. false in case binary data are unrecognized
     *
     * @param $bin
     * @return bool|string
     */
    public static function getExtension($bin)
    {
        if (self::isPng($bin)) {
            return '.png';
        }
        if (self::isJpeg($bin)) {
            return '.jpg';
        }
        if (self::isGif($bin)) {
            return '.gif';
        }
        if (self::isBmp($bin)) {
            return '.bmp';
        }

        return false;
    }

    /**
     * Check whether binary data is a JPEG image
     *
     * @param $bin
     * @return bool
     */
    public static function isJpeg($bin)
    {
        // must be a string
        if (empty($bin) || !is_string($bin)) {
            return false;
        }

        // must at least have header provided
        if (strlen($bin) < 10) {
            return false;
        }

        // check signature
        return ($bin[6] == 'J') && ($bin[7] == 'F') && ($bin[8] == 'I') && ($bin[9] == 'F');
    }

    /**
     * Check whether binary data is a PNG image
     *
     * @param $bin
     * @return bool
     */
    public static function isPng($bin)
    {
        // must be a string
        if (empty($bin) || !is_string($bin)) {
            return false;
        }

        // must at least have header provided
        if (strlen($bin) < 4) {
            return false;
        }

        // check signature
        return ($bin[1] == 'P') && ($bin[2] == 'N') && ($bin[3] == 'G');
    }

    /**
     * Check whether binary data is a BMP image
     *
     * @param $bin
     * @return bool
     */
    public static function isBmp($bin)
    {
        // must be a string
        if (empty($bin) || !is_string($bin)) {
            return false;
        }

        // must at least have header provided
        if (strlen($bin) < 2) {
            return false;
        }

        // check signature
        return ($bin[0] == 'B') && ($bin[1] == 'M');
    }

    /**
     * Check whether binary data is a GIF image
     *
     * @param $bin
     * @return bool
     */
    public static function isGif($bin)
    {
        // must be a string
        if (empty($bin) || !is_string($bin)) {
            return false;
        }

        // must at least have header provided
        if (strlen($bin) < 3) {
            return false;
        }

        // check signature
        return ($bin[0] == 'G') && ($bin[1] == 'I') && ($bin[2] == 'F');
    }
}
