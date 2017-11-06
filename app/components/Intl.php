<?php
namespace DS\Component;

use DS\Component\Intl\NativeArray;
use Phalcon\Http\Request;
use Phalcon\Mvc\User\Component;
use Phalcon\Tag;

/**
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version $Version$
 * @package DS\Component
 */
class Intl extends Component
{

    /**
     *
     */
    public function init()
    {
        /**
         * @var $request Request
         */
        $request = $this->getDI()->get('request');
        $messages = [];

        if ($request)
        {
            // Ask browser what is the best language
            $language = explode('-', $request->getBestLanguage())[0];

            // Check if we have a translation file for that lang
            if ($language && file_exists(APP_PATH . "messages/" . $language . ".php"))
            {
                /** @noinspection PhpIncludeInspection */
                $messages = require APP_PATH . "messages/" . $language . ".php";
            }
            else
            {
                // Fallback to some default
                $messages = require APP_PATH . "messages/en.php";
            }
        }

        // Return a translation object
        return new NativeArray(
            array(
                "content" => $messages
            )
        );
    }
}
