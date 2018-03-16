<?php

namespace DS\Model;

use Phalcon\Mvc\Model;

class RequestDelete extends Model
{
    public $id;
    public $user_id;
    public $row_id;
    public $comment;
    public $status;

    public function initialize()
    {
        // Setting models default table
        $this->setSource('row_delete_request');

        // Defining ORM relationships and aliases
        $this->belongsTo('user_id', '\DS\Model\User', 'id', ['alias' => 'user']);
        $this->belongsTo('row_id', '\DS\Model\TableRows', 'id', ['alias' => 'row']);
    }
}
