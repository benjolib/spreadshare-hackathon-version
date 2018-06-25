<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 25/06/18
 * Time: 10:51
 */

namespace DS\Model\Events;


use DS\Events\Table\RequestAddCreated;
use DS\Events\Table\RequestDeleteCreated;
use DS\Model\BaseEvents;
use DS\Model\RequestAdd;
use DS\Model\RequestDelete;

class RequestDeleteEvents extends BaseEvents
{
    public function afterCreate()
    {
        if ($this instanceof RequestDelete) {
            RequestDeleteCreated::after($this);
        }
    }
}