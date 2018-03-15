<?php

namespace DS\Model;

use Phalcon\Mvc\Model;

class RequestAdd extends Model
{
    public $id;
    public $user_id;
    public $table_id;
    public $content;
    public $comment;
    public $image;
    public $status;

    public function initialize()
    {
        // Setting models default table
        $this->setSource('row_add_request');

        // Defining ORM relationships and aliases
        $this->belongsTo('user_id', '\DS\Model\User', 'id', ['alias' => 'user']);
        $this->belongsTo('table_id', '\DS\Model\Tables', 'id', ['alias' => 'table']);
    }
}
