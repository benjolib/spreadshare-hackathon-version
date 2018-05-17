<?php
namespace DS\Controller;

use DS\Application;
use Phalcon\Exception;
use Phalcon\Logger;
use Phalcon\Mvc\Controller as PhalconMvcController;

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
class AboutController extends PhalconMvcController
{
    /**
     * About
     */
    public function indexAction($params = [])
    {
        try {
            $this->view->setMainView('about/index');
        } catch (Exception $e) {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }

    /**
     * About How it works
     */
    public function howitworksAction($params = [])
    {
        try {
            $this->view->setMainView('pages/about/howitworks');
        } catch (Exception $e) {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }

    /**
     * About Problem
     */
    public function problemAction($params = [])
    {
        try {
            $this->view->setMainView('pages/about/problem');
        } catch (Exception $e) {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }

    /**
     * About Solution
     */
    public function solutionAction($params = [])
    {
        try {
            $this->view->setMainView('pages/about/solution');
        } catch (Exception $e) {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }


    /**
     * About Blockchain
     */
    public function blockchainAction($params = [])
    {
        try {
            $this->view->setMainView('pages/about/blockchain');
        } catch (Exception $e) {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }


    /**
     * About roadmap
     */
    public function roadmapAction($params = [])
    {
        try {
            $this->view->setMainView('pages/about/roadmap');
        } catch (Exception $e) {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
}
