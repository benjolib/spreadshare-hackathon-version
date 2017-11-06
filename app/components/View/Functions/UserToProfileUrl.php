<?php

namespace DS\Component\View\Functions;

use Phalcon\Mvc\User\Component;

/**
 * Class UserToProfileUrl
 *
 * @package DS\Component\View\Functions
 */
class UserToProfileUrl extends Component
{
    /**
     * Parse @username mentions and replace them with the appropriate url.
     *
     * @param $text
     *
     * @return mixed
     */
    public static function parse($text)
    {
        return preg_replace('/(?<=\s|^)@(\S+)/', '<a href="/user/$1">$0</a>', $text);
    }
}