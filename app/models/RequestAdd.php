<?php

namespace DS\Model;

use DS\Model\Events\RequestAddEvents;

class RequestAdd extends RequestAddEvents
{
    public $id;
    public $user_id;
    public $table_id;
    public $content;
    public $comment;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $image;

    public $status;
    protected $createdAt;
    protected $updatedAt;

    public function initialize()
    {
        // Setting models default table
        $this->setSource('row_add_request');

        // Defining ORM relationships and aliases
        $this->belongsTo('user_id', '\DS\Model\User', 'id', ['alias' => 'user']);
        $this->belongsTo('table_id', '\DS\Model\Tables', 'id', ['alias' => 'table']);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function countPendingRequests(int $userId) :int
    {
        $phql = '
                SELECT COUNT('.RequestAdd::class.'.id) as pending
                FROM '.RequestAdd::class.' 
                INNER JOIN '.Tables::class.' ON '.Tables::class.'.id = '.RequestAdd::class.'.tableId
                WHERE '.Tables::class.'.ownerUserId = :userId:';
        $row = $this->getModelsManager()->executeQuery($phql,['userId'=>$userId]);
        return $row['pending'];
    }
}
