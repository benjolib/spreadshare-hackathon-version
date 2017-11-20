<?php

namespace DS\Component\Text;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component\Text
 */
class Csv
{
    /**
     * Parse multiline csv text string to array
     *
     * @param        $csvString
     * @param string $delimiter
     * @param bool   $skipEmptyLines
     * @param bool   $trimFields
     *
     * @return array
     */
    public function parseFromText($csvString, $delimiter = ",", $skipEmptyLines = true, $trimFields = true)
    {
        $enc   = preg_replace('/(?<!")""/', '!!Q!!', $csvString);
        $enc   = preg_replace_callback(
            '/"(.*?)"/s',
            function ($field) {
                return urlencode(utf8_encode($field[1]));
            },
            $enc
        );
        $lines = preg_split($skipEmptyLines ? ($trimFields ? '/( *\R)+/s' : '/\R+/s') : '/\R/s', $enc);
        
        return array_map(
            function ($line) use ($delimiter, $trimFields) {
                $fields = $trimFields ? array_map('trim', explode($delimiter, $line)) : explode($delimiter, $line);
                
                return array_map(
                    function ($field) {
                        return str_replace('!!Q!!', '"', utf8_decode(urldecode($field)));
                    },
                    $fields
                );
            },
            $lines
        );
    }
    
}
