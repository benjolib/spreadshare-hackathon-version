<?php
/**
 * Spreadshare
 *
 * Router Initialization
 *
 * @package DS
 * @version $Version$
 */

use Phalcon\Mvc\Dispatcher as PhDispatcher;
use Phalcon\Mvc\Router;

return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di) {
    // Register Router
    $router = new Router();
    $router->setDefaultNamespace('DS\Controller');
    
    $router->setDefaultController('Index');
    $router->setDefaultAction('index');
    $router->removeExtraSlashes(true);

    // Attach manual routes
    $manualRoutes = include_once ROOT_PATH . '/app/bootstrap/Routes.php';
    foreach ($manualRoutes as $route) {
        $router->add(
            $route['url'],
            $route['paths'],
            isset($route['methods']) ? $route['methods'] : ['GET', 'POST']
        );
    }

    // Register a 404
    // This unfortunately did not work, so i am using the dispatcher workaround below
    /*$router->notFound(
        array(
            "namespace"  => "DS\Controller",
            "controller" => "Error",
            "action"     => "show"
        )
    );*/
    
    $di->set('router', $router);
    
    /**
     * Setup dispatcher and register a 404 template
     */
    $di->set(
        'dispatcher',
        function () use ($di, $application) {
            $evManager = $di->getShared('eventsManager');
            
            /** @noinspection PhpUnusedParameterInspection */
            /*
            $evManager->attach(
                "dispatch:afterDispatch",
                function ($event, PhDispatcher $dispatcher) use($di)
                {
                }
            );
            */
            
            /** @noinspection PhpUnusedParameterInspection */
            $evManager->attach(
                "dispatch:beforeExecuteRoute",
                function ($event, PhDispatcher $dispatcher) use ($di) {
                    // Enable camelized routes, so like my-route is transformed to MyRoute.
                    $actionName     = \Phalcon\Text::camelize($dispatcher->getActionName());
                    $controllerName = \Phalcon\Text::camelize($dispatcher->getControllerName());
                    $dispatcher->setActionName($actionName);
                    $dispatcher->setControllerName($controllerName);
                    
                    // Check if this page needs a login
                    $ctrl = $dispatcher->getActiveController();
                    if (is_a($ctrl, 'DS\Interfaces\LoginAwareController'))
                    {
                        /**
                         * @var $ctrl DS\Interfaces\LoginAwareController
                         */
                        if ($ctrl->needsLogin() && !\DS\Component\ServiceManager::instance($di)->getAuth()->loggedIn())
                        {
                            // @todo may use http redirect instead?
                            //$response = new \Phalcon\Http\Response();
                            //$response->redirect('login');
                            
                            // .. and if so, redirect to the login page
                            $dispatcher->forward(
                                [
                                    'controller' => 'Login',
                                    'action' => 'index',
                                ]
                            );
                            
                            // @todo inform view that the user is not logged in
                            //$view = $di->get(\DS\Constants\Services::VIEW);
                        }
                    }
                    
                    return true;
                }
            );
            
            /** @noinspection PhpUnusedParameterInspection */
            $evManager->attach(
                "dispatch:beforeException",
                function ($event, PhDispatcher $dispatcher, Exception $exception) {
                    $dispatcher->getDI()->get('logger')->warning($exception->getMessage());
                    
                    switch ($exception->getCode())
                    {
                        case PhDispatcher::EXCEPTION_CYCLIC_ROUTING:
                        case PhDispatcher::EXCEPTION_INVALID_HANDLER:
                        case PhDispatcher::EXCEPTION_INVALID_PARAMS:
                        case PhDispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                        case PhDispatcher::EXCEPTION_ACTION_NOT_FOUND:
                            $dispatcher->forward(
                                [
                                    'controller' => 'Error',
                                    'action' => 'notFound',
                                ]
                            );
                            break;
                        case PhDispatcher::EXCEPTION_NO_DI:
                            $dispatcher->forward(
                                [
                                    'controller' => 'Error',
                                    'action' => 'error',
                                    'params' => [
                                        $exception,
                                    ],
                                ]
                            );
                            break;
                    }
                    
                    return false;
                }
            );
            
            $dispatcher = new PhDispatcher();
            $dispatcher->setEventsManager($evManager);
            
            return $dispatcher;
        },
        true
    );
};
