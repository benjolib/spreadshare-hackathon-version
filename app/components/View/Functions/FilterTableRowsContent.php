<?php

namespace DS\Component\View\Functions;

use Phalcon\Mvc\User\Component;

/**
 * Class UserToProfileUrl
 *
 * @package DS\Component\View\Functions
 */
class FilterTableRowsContent extends Component
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
        return preg_replace_callback('/((http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?)/', function ($matches) {
                    return '<a class="re-table-link" target="_blank" title="' . $matches[0] . '" href="' . $matches[0] . '">' . str_ireplace('www.', '', parse_url($matches[0])['host']) . '</a>';
                }, $text);
    }
}