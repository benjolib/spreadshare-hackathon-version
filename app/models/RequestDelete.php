<?php

namespace DS\Model;

class RequestDelete extends BaseEvents
{
    public $id;
    public $user_id;
    public $row_id;
    public $comment;
    public $status;
    protected $createdAt;
    protected $updatedAt;

    public function initialize()
    {
        // Setting models default table
        $this->setSource('row_delete_request');

        // Defining ORM relationships and aliases
        $this->belongsTo('user_id', '\DS\Model\User', 'id', ['alias' => 'user']);
        $this->belongsTo('row_id', '\DS\Model\TableRows', 'id', ['alias' => 'row']);
    }
}
