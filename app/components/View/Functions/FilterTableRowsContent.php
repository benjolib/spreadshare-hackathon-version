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
    public static function parse($rawText)
    {
        $maxPos = 161;
        $text = '';
        $linkStrippedText = preg_replace_callback('/((http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?)/', function ($matches) {
            return str_ireplace('www.', '', parse_url($matches[0])['host']);
        }, $rawText);
        if (strlen($linkStrippedText) > $maxPos) {
            $lastPos = ($maxPos - 3) - strlen($rawText);
            $text = substr($rawText, 0, strrpos($rawText, ' ', $lastPos)) . '...';
            $text .= '<a href="javascript:;" class="table-cell-show-more-button l-button" data-dropdown-placement="bottom">More</a>';
            $text .= '<div class="l-dropdown sh-dropdown table-cell-show-more-dropdown">' . $rawText . '</div>';
        } else {
            $text = $rawText;
        }
        return preg_replace_callback('/((http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?)/', function ($matches) {
            return '<a class="re-table-link" target="_blank" title="' . $matches[0] . '" href="' . $matches[0] . '">' . str_ireplace('www.', '', parse_url($matches[0])['host']) . '</a>';
        }, $text);
    }
}
