<?php

namespace DS\Model\Abstracts;

/**
 * AbstractUserNotifications
 * 
 * @package DS\Model\Abstracts
 * @autogenerated by Phalcon Developer Tools
 * @date 2017-11-08, 17:05:52
 */
abstract class AbstractUserNotifications extends \DS\Model\Base
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
     * @Column(type="integer", length=5, nullable=true)
     */
    protected $notificationType;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $text;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $placeholders;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $createdAt;

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
     * Method to set the value of field notificationType
     *
     * @param integer $notificationType
     * @return $this
     */
    public function setNotificationType($notificationType)
    {
        $this->notificationType = $notificationType;

        return $this;
    }

    /**
     * Method to set the value of field text
     *
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Method to set the value of field placeholders
     *
     * @param string $placeholders
     * @return $this
     */
    public function setPlaceholders($placeholders)
    {
        $this->placeholders = $placeholders;

        return $this;
    }

    /**
     * Method to set the value of field createdAt
     *
     * @param integer $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

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
     * Returns the value of field notificationType
     *
     * @return integer
     */
    public function getNotificationType()
    {
        return $this->notificationType;
    }

    /**
     * Returns the value of field text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Returns the value of field placeholders
     *
     * @return string
     */
    public function getPlaceholders()
    {
        return $this->placeholders;
    }

    /**
     * Returns the value of field createdAt
     *
     * @return integer
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("spreadshare");
        $this->setSource("userNotifications");
        $this->belongsTo('userId', 'DS\Model\Abstracts\User', 'id', ['alias' => 'User']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'userNotifications';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return AbstractUserNotifications[]|AbstractUserNotifications|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return AbstractUserNotifications|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
