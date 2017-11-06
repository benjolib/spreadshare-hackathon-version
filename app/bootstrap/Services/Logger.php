<?php
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Logger\Multiple as MultipleStream;

/**
 * Spreadshare
 *
 * Logger Initialization
 *
 * @package DS
 * @version $Version$
 */

return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di)
{
    $di->set(
        \DS\Constants\Services::ERRORLOGGER,
        function ()
        {
            /*
            $logger = new MultipleStream();
            $logger->push(new FileAdapter(ROOT_PATH . 'system/log/error'));
            */

            return new FileAdapter(ROOT_PATH . 'system/log/error');
        }
    );

    $di->set(
        \DS\Constants\Services::LOGGER,
        function ()
        {
            return new FileAdapter(ROOT_PATH . 'system/log/application');
        }
    );

    $di->set(
        \DS\Constants\Services::CLILOGGER,
        function ()
        {
            $logger = new MultipleStream();
            $logger->push(new FileAdapter(ROOT_PATH . 'system/log/cli'));

            return $logger;
        }
    );
};