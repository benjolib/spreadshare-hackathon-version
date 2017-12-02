<?php

namespace DS\Model\Abstracts;

/**
 * AbstractUserStats
 * 
 * @package DS\Model\Abstracts
 * @autogenerated by Phalcon Developer Tools
 * @date 2017-12-02, 00:38:05
 */
abstract class AbstractUserStats extends \DS\Model\Base
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    protected $userId;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $tablesOwnerCount;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $rowsOwnerCount;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $unreadNotifications;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $contributions;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $tablesCreated;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $rejectedChangeRequests;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $approvedChangeRequests;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field userId
     *
     * @param integer $userId
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Method to set the value of field tablesOwnerCount
     *
     * @param integer $tablesOwnerCount
     * @return $this
     */
    public function setTablesOwnerCount($tablesOwnerCount)
    {
        $this->tablesOwnerCount = $tablesOwnerCount;

        return $this;
    }

    /**
     * Method to set the value of field rowsOwnerCount
     *
     * @param integer $rowsOwnerCount
     * @return $this
     */
    public function setRowsOwnerCount($rowsOwnerCount)
    {
        $this->rowsOwnerCount = $rowsOwnerCount;

        return $this;
    }

    /**
     * Method to set the value of field unreadNotifications
     *
     * @param integer $unreadNotifications
     * @return $this
     */
    public function setUnreadNotifications($unreadNotifications)
    {
        $this->unreadNotifications = $unreadNotifications;

        return $this;
    }

    /**
     * Method to set the value of field contributions
     *
     * @param integer $contributions
     * @return $this
     */
    public function setContributions($contributions)
    {
        $this->contributions = $contributions;

        return $this;
    }

    /**
     * Method to set the value of field tablesCreated
     *
     * @param integer $tablesCreated
     * @return $this
     */
    public function setTablesCreated($tablesCreated)
    {
        $this->tablesCreated = $tablesCreated;

        return $this;
    }

    /**
     * Method to set the value of field rejectedChangeRequests
     *
     * @param integer $rejectedChangeRequests
     * @return $this
     */
    public function setRejectedChangeRequests($rejectedChangeRequests)
    {
        $this->rejectedChangeRequests = $rejectedChangeRequests;

        return $this;
    }

    /**
     * Method to set the value of field approvedChangeRequests
     *
     * @param integer $approvedChangeRequests
     * @return $this
     */
    public function setApprovedChangeRequests($approvedChangeRequests)
    {
        $this->approvedChangeRequests = $approvedChangeRequests;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Returns the value of field tablesOwnerCount
     *
     * @return integer
     */
    public function getTablesOwnerCount()
    {
        return $this->tablesOwnerCount;
    }

    /**
     * Returns the value of field rowsOwnerCount
     *
     * @return integer
     */
    public function getRowsOwnerCount()
    {
        return $this->rowsOwnerCount;
    }

    /**
     * Returns the value of field unreadNotifications
     *
     * @return integer
     */
    public function getUnreadNotifications()
    {
        return $this->unreadNotifications;
    }

    /**
     * Returns the value of field contributions
     *
     * @return integer
     */
    public function getContributions()
    {
        return $this->contributions;
    }

    /**
     * Returns the value of field tablesCreated
     *
     * @return integer
     */
    public function getTablesCreated()
    {
        return $this->tablesCreated;
    }

    /**
     * Returns the value of field rejectedChangeRequests
     *
     * @return integer
     */
    public function getRejectedChangeRequests()
    {
        return $this->rejectedChangeRequests;
    }

    /**
     * Returns the value of field approvedChangeRequests
     *
     * @return integer
     */
    public function getApprovedChangeRequests()
    {
        return $this->approvedChangeRequests;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("spreadshare");
        $this->setSource("userStats");
        $this->belongsTo('userId', 'DS\Model\Abstracts\User', 'id', ['alias' => 'User']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'userStats';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return AbstractUserStats[]|AbstractUserStats|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return AbstractUserStats|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
