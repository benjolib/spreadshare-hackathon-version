<?php

namespace DS\Model\Abstracts;

/**
 * AbstractTableLocations
 * 
 * @package DS\Model\Abstracts
 */
abstract class AbstractBundleTags extends \DS\Model\Base
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $bundleId;

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $tagId;

    /**
     * Method to set the value of field bundleId
     *
     * @param integer $bundleId
     * @return $this
     */
    public function setBundleId($bundleId)
    {
        $this->bundleId = $bundleId;

        return $this;
    }

    /**
     * Method to set the value of field tagId
     *
     * @param integer $tagId
     * @return $this
     */
    public function setTagId($tagId)
    {
        $this->tagId = $tagId;

        return $this;
    }

    /**
     * Returns the value of field bundleId
     *
     * @return integer
     */
    public function getBundleId()
    {
        return $this->bundleId;
    }

    /**
     * Returns the value of field tagId
     *
     * @return integer
     */
    public function getTagId()
    {
        return $this->tagId;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("spreadshare");
        $this->setSource("bundleTags");
        $this->belongsTo('bundleId', 'DS\Model\Bundles', 'id', ['alias' => 'Bundles']);
        $this->belongsTo('tagId', 'DS\Model\Tags', 'id', ['alias' => 'Tags']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'bundleTags';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return AbstractTableLocations[]|AbstractTableLocations|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return AbstractTableLocations|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
}
