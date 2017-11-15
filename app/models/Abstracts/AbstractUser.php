<?php

namespace DS\Model\Abstracts;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

/**
 * AbstractUser
 * 
 * @package DS\Model\Abstracts
 * @autogenerated by Phalcon Developer Tools
 * @date 2017-11-15, 14:21:43
 */
abstract class AbstractUser extends \DS\Model\Base
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
     * @Column(type="string", length=100, nullable=true)
     */
    protected $handle;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $name;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $email;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $securitySalt;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=true)
     */
    protected $authUid;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $authProvider;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=true)
     */
    protected $location;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $description;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=true)
     */
    protected $website;

    /**
     *
     * @var string
     * @Column(type="string", length=140, nullable=true)
     */
    protected $tagline;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $image;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=true)
     */
    protected $emailConfirmationToken;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $passwordResetToken;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $passwordResetSentAt;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=true)
     */
    protected $lastSessionId;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $lastLogin;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    protected $confirmed;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    protected $status;

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
     * Method to set the value of field handle
     *
     * @param string $handle
     * @return $this
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;

        return $this;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Method to set the value of field securitySalt
     *
     * @param string $securitySalt
     * @return $this
     */
    public function setSecuritySalt($securitySalt)
    {
        $this->securitySalt = $securitySalt;

        return $this;
    }

    /**
     * Method to set the value of field authUid
     *
     * @param string $authUid
     * @return $this
     */
    public function setAuthUid($authUid)
    {
        $this->authUid = $authUid;

        return $this;
    }

    /**
     * Method to set the value of field authProvider
     *
     * @param string $authProvider
     * @return $this
     */
    public function setAuthProvider($authProvider)
    {
        $this->authProvider = $authProvider;

        return $this;
    }

    /**
     * Method to set the value of field location
     *
     * @param string $location
     * @return $this
     */
    public function setLocation($location)
    {
        $this->location = $location;

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
     * Method to set the value of field website
     *
     * @param string $website
     * @return $this
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Method to set the value of field tagline
     *
     * @param string $tagline
     * @return $this
     */
    public function setTagline($tagline)
    {
        $this->tagline = $tagline;

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
     * Method to set the value of field emailConfirmationToken
     *
     * @param string $emailConfirmationToken
     * @return $this
     */
    public function setEmailConfirmationToken($emailConfirmationToken)
    {
        $this->emailConfirmationToken = $emailConfirmationToken;

        return $this;
    }

    /**
     * Method to set the value of field passwordResetToken
     *
     * @param string $passwordResetToken
     * @return $this
     */
    public function setPasswordResetToken($passwordResetToken)
    {
        $this->passwordResetToken = $passwordResetToken;

        return $this;
    }

    /**
     * Method to set the value of field passwordResetSentAt
     *
     * @param integer $passwordResetSentAt
     * @return $this
     */
    public function setPasswordResetSentAt($passwordResetSentAt)
    {
        $this->passwordResetSentAt = $passwordResetSentAt;

        return $this;
    }

    /**
     * Method to set the value of field lastSessionId
     *
     * @param string $lastSessionId
     * @return $this
     */
    public function setLastSessionId($lastSessionId)
    {
        $this->lastSessionId = $lastSessionId;

        return $this;
    }

    /**
     * Method to set the value of field lastLogin
     *
     * @param integer $lastLogin
     * @return $this
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Method to set the value of field confirmed
     *
     * @param integer $confirmed
     * @return $this
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    /**
     * Method to set the value of field status
     *
     * @param integer $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

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
     * Returns the value of field handle
     *
     * @return string
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value of field email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Returns the value of field securitySalt
     *
     * @return string
     */
    public function getSecuritySalt()
    {
        return $this->securitySalt;
    }

    /**
     * Returns the value of field authUid
     *
     * @return string
     */
    public function getAuthUid()
    {
        return $this->authUid;
    }

    /**
     * Returns the value of field authProvider
     *
     * @return string
     */
    public function getAuthProvider()
    {
        return $this->authProvider;
    }

    /**
     * Returns the value of field location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
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
     * Returns the value of field website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Returns the value of field tagline
     *
     * @return string
     */
    public function getTagline()
    {
        return $this->tagline;
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
     * Returns the value of field emailConfirmationToken
     *
     * @return string
     */
    public function getEmailConfirmationToken()
    {
        return $this->emailConfirmationToken;
    }

    /**
     * Returns the value of field passwordResetToken
     *
     * @return string
     */
    public function getPasswordResetToken()
    {
        return $this->passwordResetToken;
    }

    /**
     * Returns the value of field passwordResetSentAt
     *
     * @return integer
     */
    public function getPasswordResetSentAt()
    {
        return $this->passwordResetSentAt;
    }

    /**
     * Returns the value of field lastSessionId
     *
     * @return string
     */
    public function getLastSessionId()
    {
        return $this->lastSessionId;
    }

    /**
     * Returns the value of field lastLogin
     *
     * @return integer
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Returns the value of field confirmed
     *
     * @return integer
     */
    public function getConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * Returns the value of field status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
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
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email',
            new EmailValidator(
                [
                    'model'   => $this,
                    'message' => 'Please enter a correct email address',
                ]
            )
        );

        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("spreadshare");
        $this->setSource("user");
        $this->hasMany('id', 'DS\Model\Abstracts\ChangeRequests', 'userId', ['alias' => 'ChangeRequests']);
        $this->hasMany('id', 'DS\Model\Abstracts\TableCells', 'lastEditedById', ['alias' => 'TableCells']);
        $this->hasMany('id', 'DS\Model\Abstracts\TableCells', 'userId', ['alias' => 'TableCells']);
        $this->hasMany('id', 'DS\Model\Abstracts\TableColumns', 'userId', ['alias' => 'TableColumns']);
        $this->hasMany('id', 'DS\Model\Abstracts\TableCommentVotes', 'userId', ['alias' => 'TableCommentVotes']);
        $this->hasMany('id', 'DS\Model\Abstracts\TableComments', 'userId', ['alias' => 'TableComments']);
        $this->hasMany('id', 'DS\Model\Abstracts\TableRowVotes', 'userId', ['alias' => 'TableRowVotes']);
        $this->hasMany('id', 'DS\Model\Abstracts\TableRows', 'userId', ['alias' => 'TableRows']);
        $this->hasMany('id', 'DS\Model\Abstracts\TableSubscription', 'userId', ['alias' => 'TableSubscription']);
        $this->hasMany('id', 'DS\Model\Abstracts\TableTokens', 'userId', ['alias' => 'TableTokens']);
        $this->hasMany('id', 'DS\Model\Abstracts\TableViews', 'userId', ['alias' => 'TableViews']);
        $this->hasMany('id', 'DS\Model\Abstracts\TableVotes', 'userId', ['alias' => 'TableVotes']);
        $this->hasMany('id', 'DS\Model\Abstracts\Tables', 'ownerUserId', ['alias' => 'Tables']);
        $this->hasMany('id', 'DS\Model\Abstracts\Tags', 'userId', ['alias' => 'Tags']);
        $this->hasMany('id', 'DS\Model\Abstracts\UserConnections', 'userId', ['alias' => 'UserConnections']);
        $this->hasMany('id', 'DS\Model\Abstracts\UserFollower', 'followedByUserId', ['alias' => 'UserFollower']);
        $this->hasMany('id', 'DS\Model\Abstracts\UserFollower', 'userId', ['alias' => 'UserFollower']);
        $this->hasMany('id', 'DS\Model\Abstracts\UserLocations', 'userId', ['alias' => 'UserLocations']);
        $this->hasMany('id', 'DS\Model\Abstracts\UserNotifications', 'userId', ['alias' => 'UserNotifications']);
        $this->hasMany('id', 'DS\Model\Abstracts\UserResetPassword', 'userId', ['alias' => 'UserResetPassword']);
        $this->hasMany('id', 'DS\Model\Abstracts\UserSettings', 'userId', ['alias' => 'UserSettings']);
        $this->hasMany('id', 'DS\Model\Abstracts\UserStats', 'userId', ['alias' => 'UserStats']);
        $this->hasMany('id', 'DS\Model\Abstracts\UserTopics', 'userId', ['alias' => 'UserTopics']);
        $this->hasMany('id', 'DS\Model\Abstracts\Wallet', 'userId', ['alias' => 'Wallet']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return AbstractUser[]|AbstractUser|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return AbstractUser|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
