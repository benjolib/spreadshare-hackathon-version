<?php

namespace DS\Model\Abstracts;

/**
 * AbstractTopics
 * 
 * @package DS\Model\Abstracts
 * @autogenerated by Phalcon Developer Tools
 * @date 2017-11-08, 16:02:39
 */
abstract class AbstractTopics extends \DS\Model\Base
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=1, nullable=false)
     */
    protected $id;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=true)
     */
    protected $title;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=true)
     */
    protected $image;

    /**
     *
     * @var string
     * @Column(type="string", length=6, nullable=true)
     */
    protected $color;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $description;

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
     * Method to set the value of field title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Method to set the value of field image
     *
     * @param string $image
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Method to set the value of field color
     *
     * @param string $color
     * @return $this
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Method to set the value of field description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * Returns the value of field title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the value of field image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Returns the value of field color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Returns the value of field description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("spreadshare");
        $this->setSource("topics");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'topics';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return AbstractTopics[]|AbstractTopics|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return AbstractTopics|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
