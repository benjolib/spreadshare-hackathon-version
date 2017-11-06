<?php

/**
 * Spreadshare
 *
 * Queue Initialization
 *
 * @package DS
 * @version $Version$
 */
return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di)
{
    /**
     * Setup Beanstalk service
     *
     * @see https://github.com/phalcon/incubator/blob/master/Library/Phalcon/Queue/Beanstalk/README.md
     *
     * @return
     */
    $di->set(
        'queue',
        function () use ($di)
        {
            return new \DS\Component\Queue\Beanstalk\BeanstalkQueue(
                $di->get(\DS\Constants\Services::BEANSTALK)
            );
        }
    );

};