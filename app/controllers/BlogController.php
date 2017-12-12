<?php

namespace DS\Controller;

use DS\Application;
use Phalcon\Exception;
use Phalcon\Logger;

/**
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
class BlogController
    extends BaseController
{
    /**
     * Spreadshare
     */
    public function indexAction($params = [])
    {
        try
        {
            $this->view->setMainView('pages/blog/feed');

            $posts = $this->posts_display('spreadshare');

            $this->view->setVar('posts', $posts);

        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }


    public function posts_display($handle){

    $data = file_get_contents("https://medium.com/".$handle."/latest?format=json");
    $data = str_replace("])}while(1);</x>", "", $data);
    //If handle provided is specified as a publication
    $json = json_decode($data);
    if(isset($json->payload->posts))
     {
       $posts = $json->payload->posts;
     } else {
       $posts = [];
     }

    return $posts;


    }


}
