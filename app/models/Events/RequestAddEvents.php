<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 25/06/18
 * Time: 10:51
 */

namespace DS\Model\Events;


use DS\Events\Table\RequestAddCreated;
use DS\Events\Table\RequestAddUpdated;
use DS\Model\BaseEvents;
use DS\Model\RequestAdd;

class RequestAddEvents extends BaseEvents
{

    public function afterCreate()
    {
        if ($this instanceof RequestAdd) {
            RequestAddCreated::after($this);
        }
    }

    public function afterUpdate()
    {
        if ($this instanceof RequestAdd) {
            RequestAddUpdated::after($this);
        }
    }
}