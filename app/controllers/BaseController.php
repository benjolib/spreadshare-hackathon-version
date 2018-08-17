<?php

namespace DS\Controller;

use DS\Component\ServiceManager;
use DS\Controller\Validation\ValidationSchema;
use Phalcon\Mvc\Controller as PhalconMvcController;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
abstract class BaseController extends PhalconMvcController
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @param ValidationSchema $schema
     *
     * @return \Phalcon\Validation\Message\Group
     */
    protected function validate(ValidationSchema $schema)
    {
        $errors = $schema->validate($this->request->getPost());
        if (count($errors)) {
            $userErrors = [];
            foreach ($errors as $error) {
                $userErrors[$error->getField()] = $error->getMessage();
            }

            $this->view->setVar('errors', $userErrors);
        }

        return $errors;
    }

    /**
     * Initialize controller
     */
    public function initialize()
    {
        $this->view->setVar('env', ENV);
        if (!$this->serviceManager) {
            $this->serviceManager = ServiceManager::instance($this->di);
        }

        $this->view->setVar('base_url', $this->getBaseUrl());

        // Providing the instance to our view
        if (!isset($this->view->auth)) {
            $this->view->setVar('auth', $this->serviceManager->getAuth());
        }
    }

    /**
     * @return string base URL - without script name
     */
    public function getBaseUrl()
    {
        // output: /myproject/index.php
        $currentPath = $_SERVER['PHP_SELF'];

        // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index )
        $pathInfo = pathinfo($currentPath);

        // output: localhost
        $hostName = $_SERVER['HTTP_HOST'];

        // output: http://
        $protocol = (strtolower(substr($_SERVER['SERVER_PROTOCOL'], 0, 5)) === 'https') ? 'https' : 'http';

        // return: http://localhost/myproject/
        return $protocol . '://' . $hostName . $pathInfo['dirname'];
    }

    /**
     * Redirects user back to previous URL
     */
    protected function _redirectBack()
    {
        return $this->response->redirect($this->request->getServer('HTTP_REFERER'));
    }
}
