<?php

namespace DS\Model;

use DS\Component\Cache\Memcache;
use DS\Component\ServiceManager;
use DS\Constants\Services;
use Phalcon\Db\ResultInterface;
use Phalcon\Di;

/**
 * Spreadshare
 *
 * Base model. Used for further method rollouts.
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static findFirstById(int $id)
 */
abstract class Base
    extends BaseEvents
{
    /**
     * The default user id to look for. Usually the current user that is logged in.
     *
     * @var int
     */
    private $defaultUserId;
    
    /**
     * @var ServiceManager
     */
    protected $serviceManager;
    
    /**
     * @var static[]
     */
    protected static $getCache = [];
    
    /**
     * Get the user id that is checked for every user-related database entries.
     *
     * @return int
     */
    public function getDefaultUserId()
    {
        return $this->defaultUserId;
    }
    
    /**
     * Set the user id that is checked for every user-related database entries.
     *
     * @param int $defaultUserId
     *
     * @return $this
     */
    public function setDefaultUserId($defaultUserId)
    {
        $this->defaultUserId = $defaultUserId;
        
        return $this;
    }
    
    /**
     * @param string $column
     * @param string $id
     */
    public function deleteByFieldValue(string $column = 'id', string $id)
    {
        $this->getWriteConnection()->delete($this->getSource(), sprintf("%s = ?", $column), [$id]);
    }
    
    /**
     * Return model instance by id
     *
     * @param int $id
     *
     * @return $this
     */
    public static function get($id, $column = 'id')
    {
        /**
         * @todo Use memcache or redis for this with a lower lifetime of e.g. 5 minutes
         */
        if (!isset(static::$getCache[static::class][$id]))
        {
            static::$getCache[static::class][$id] = static::findFirst(
                [
                    "conditions" => sprintf("%s = ?0", $column),
                    "bind" => [$id],
                ]
            ) ?: new static();
        }
        
        return static::$getCache[static::class][$id];
    }
    
    /**
     * Allows to query this model by the given sql field name and it's value
     *
     * @param string $field
     * @param string $value
     *
     * @return static
     */
    public static function findByFieldValue($field, $value)
    {
        if (property_exists(static::class, $field))
        {
            return parent::findFirst(
                [
                    "conditions" => sprintf("%s = ?0", $field),
                    "limit" => 1,
                    "bind" => [$value],
                ]
            );
        }
        
        throw new \InvalidArgumentException('Invalid field name provided. This field is not available in this model.');
    }
    
    /**
     * Allows to query this model by the given sql field name and it's value
     *
     * @param string $field
     * @param string $value
     *
     * @return static[]
     */
    public static function findAllByFieldValue($field, $value)
    {
        if (property_exists(static::class, $field))
        {
            return parent::find(
                [
                    "conditions" => sprintf("%s = ?0", $field),
                    "bind" => [$value],
                ]
            );
        }
        
        throw new \InvalidArgumentException('Invalid field name provided. This field is not available in this model.');
    }
    
    /**
     * @param int    $limit
     * @param string $order
     *
     * @return static[]
     */
    public static function findWithLimit($limit, $order = null)
    {
        return self::find(
            [
                "limit" => $limit,
                "order" => $order,
            ]
        );
    }
    
    /**
     * $id is the id value of current table. ( = findFirstById is called)
     *
     * @param int $id
     *
     * @return $this
     */
    public static function getInstance($id = null)
    {
        $instance = null;
        if ($id)
        {
            $instance = self::findFirstById($id);
        }
        
        return !$instance ? new static : $instance;
    }
    
    /**
     * @param int|string $id
     *
     * @return string
     */
    public static function calculateETag($id)
    {
        $auth = ServiceManager::instance()->getAuth();
        
        return md5(self::get((int) $id)->__get(self::$updateColumn) . $auth->getUserId());
    }
    
    /*
     * Still unsure about this feature
     * It's maybe better implemented via Decorator Pattern for the Query-Builder
     *
    protected function applyLimit(Limit $limit = null)
    {
        if ($limit)
        {
            //$this->limit($limit->getLimit(), $limit->getOffset());
        }
    }
    */
    
    /*
     * Returns related records based on defined relations
     *
     * @param string alias
     * @param array arguments
     * @return \Phalcon\Mvc\Model\ResultsetInterface
     */
    public function getRelated($alias, $arguments = null)
    {
        return parent::getRelated(
            $alias,
            array_merge_recursive(
                $arguments,
                [
                    'cache' => [
                        'key' => 'modelsCache.' . $alias,
                        'lifetime' => 84600,
                    ],
                ]
            )
        );
    }
    
    /**
     * Get human timing for specific field
     *
     * @param $field
     *
     * @return string
     */
    public function humanTiming($field = 'createdAt')
    {
        $time = $this->$field;
        $time = time() - $time; // to get the time since that moment
        
        if ($time < 60)
        {
            return 'Just now';
        }
        
        $tokens = [
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second',
        ];
        
        foreach ($tokens as $unit => $text)
        {
            if ($time < $unit)
            {
                continue;
            }
            $numberOfUnits = floor($time / $unit);
            
            return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's ago' : ' ago');
        }
        
        return '';
    }
    
    /**
     * @return Memcache
     */
    public function getCache()
    {
        return $this->getDI()->get(Services::MEMCACHE);
    }
    
    /**
     * Sends SQL statements to the read database server returning the success state.
     *
     * @param string $sqlStatement
     * @param mixed  $placeholders
     * @param mixed  $dataTypes
     *
     * @return bool|ResultInterface
     */
    public function readQuery($sqlStatement, $placeholders = null, $dataTypes = null)
    {
        return $this->getReadConnection()->query($sqlStatement, $placeholders, $dataTypes);
    }
    
    /**
     * Sends SQL statements to the write database server returning the success state.
     *
     * @param string $sqlStatement
     * @param mixed  $placeholders
     * @param mixed  $dataTypes
     *
     * @return bool|ResultInterface
     */
    public function writeQuery($sqlStatement, $placeholders = null, $dataTypes = null)
    {
        return $this->getWriteConnection()->query($sqlStatement, $placeholders, $dataTypes);
    }
    
    /**
     * @return static
     */
    public static function factory(Di $di = null)
    {
        return new static($di);
    }
    
    /**
     * Initialize all models
     */
    public function initialize()
    {
        $this->setConnectionService('write-database');
        $this->setReadConnectionService('read-database');
        $this->setWriteConnectionService('write-database');
        
        $this->serviceManager = ServiceManager::instance($this->getDI());
        $this->defaultUserId  = $this->serviceManager->getAuth()->getUserId();
        
    }
}
