<?php

namespace DS\Component\View\Volt;

use DS\Application;
use Phalcon\DiInterface;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\ViewBaseInterface;

/**
 * The 'volt' adapter for View Teamplate/Engine.
 */
class VoltAdapter extends Volt
{
    /**
     * @var array
     */
    private $functions = [
        # misc
        'di',
        'auth',
        'serviceManager',
        /*
        'env',
        'csrf_field',
        'dd',
        'config',
        'cache',
        'config',
        'db',
        'filter',
        'flysystem',
        'flysystem_manager',
        'lang',
        'log',
        'queue',
        'redirect',
        'request',
        'response',
        'route',
        'security',
        'session',
        'tag',
        'url',
        'view',
        # path
        'base_uri',
        */
        # php
        'strtotime',
        'explode',
        'implode',
    ];
    
    /**
     * Constructor.
     *
     * @param mixed|\Phalcon\Mvc\ViewBaseInterface $view
     * @param mixed|\Phalcon\DiInterface           $di
     */
    public function __construct(ViewBaseInterface $view, DiInterface $di = null, Application $application)
    {
        parent::__construct($view, $di);
        
        $this->setOptions(
            [
                'compiledSeparator' => '_',
                "compiledPath" => $application->getRootDirectory() . "system/cache/volt/",
                'stat' => true,
                'compileAlways' => true,
            ]
        );
        
        //$view->cache();
        
        /**
         * Add some functions to the volt compiler
         *
         * @var $compiler Volt\Compiler
         */
        $compiler = $this->getCompiler();
        
        foreach ($this->functions as $func)
        {
            $compiler->addFunction($func, $func);
        }
        
        $compiler->addFunction(
            'formatTimestamp',
            function ($key) {
                return "\\DS\\Component\\UserComponent\\StringFormat::factory()->prettyDateTimestamp({$key})";
            }
        );
        
        $compiler->addFunction(
            'parseUser',
            function ($key) {
                return "\\DS\\Component\\View\\Functions\\UserToProfileUrl::parse({$key})";
            }
        );
        
        $compiler->addFunction(
            'reactArray',
            function ($key) {
                return "htmlentities(json_encode({$key}))";
            }
        );
    }
}