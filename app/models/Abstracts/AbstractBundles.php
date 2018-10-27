<?php

namespace DS\Model\Abstracts;

use DS\Exceptions\InvalidStreamTitleException;

/**
 * AbstractBundles
 *
 * @package DS\Model\Abstracts
 */
abstract class AbstractBundles extends \DS\Model\Base
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
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    protected $title;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $image;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $createdAt;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $updatedAt;

    /**
     * @var boolean
     * @Column(type="boolean")
     */
    protected $featured;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    protected $slug;

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
        if (empty($title)) {
            throw new InvalidStreamTitleException('Please give a title for your Bundle');
        }

        if (strlen($title) < 4) {
            throw new InvalidStreamTitleException('Please provide at least four characters');
        }

        $model = self::findByFieldValue('title', $title);
        if ($model && $model->getId() != $this->getId()) {
            throw new InvalidStreamTitleException('A Bundle with the exact same title already exists. Please choose another title');
        }

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
     * Method to set the value of field updatedAt
     *
     * @param integer $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

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
     * Returns the value of field updatedAt
     *
     * @return integer
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
        $this->setSchema('spreadshare');
        $this->setSource('bundles');
        $this->hasMany('id', 'DS\Model\BundleTags', 'bundleId', ['alias' => 'BundleTags']);
        $this->hasManyToMany('id', 'DS\Model\BundleTags', 'bundleId', 'tagId', 'DS\Model\Tags', 'id');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'bundles';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return AbstractTables[]|AbstractTables|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return AbstractTables|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * @param bool $featured
     * @return AbstractBundles
     */
    public function setFeatured(int $featured): AbstractBundles
    {
        $this->featured = $featured;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFeatured(): bool
    {
        return $this->featured;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return AbstractBundles
     */
    public function setSlug(string $slug): AbstractBundles
    {
        $this->slug = $slug;
        return $this;
    }
}
