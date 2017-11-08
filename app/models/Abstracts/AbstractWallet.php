<?php

namespace DS\Model\Abstracts;

/**
 * AbstractWallet
 * 
 * @package DS\Model\Abstracts
 * @autogenerated by Phalcon Developer Tools
 * @date 2017-11-08, 17:05:52
 */
abstract class AbstractWallet extends \DS\Model\Base
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
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $data;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=true)
     */
    protected $contractAddress;

    /**
     *
     * @var double
     * @Column(type="double", nullable=true)
     */
    protected $tokens;

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
     * Method to set the value of field data
     *
     * @param string $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Method to set the value of field contractAddress
     *
     * @param string $contractAddress
     * @return $this
     */
    public function setContractAddress($contractAddress)
    {
        $this->contractAddress = $contractAddress;

        return $this;
    }

    /**
     * Method to set the value of field tokens
     *
     * @param double $tokens
     * @return $this
     */
    public function setTokens($tokens)
    {
        $this->tokens = $tokens;

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
     * Returns the value of field data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Returns the value of field contractAddress
     *
     * @return string
     */
    public function getContractAddress()
    {
        return $this->contractAddress;
    }

    /**
     * Returns the value of field tokens
     *
     * @return double
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("spreadshare");
        $this->setSource("wallet");
        $this->belongsTo('userId', 'DS\Model\Abstracts\User', 'id', ['alias' => 'User']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'wallet';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return AbstractWallet[]|AbstractWallet|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return AbstractWallet|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
