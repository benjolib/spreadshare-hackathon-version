<?php

namespace DS\Component\Elasticsearch;

use DS\Model\Elasticsearch\Schema\Definition;
use DS\Model\Elasticsearch\Schema\Initialize;
use Elastica\Client;
use Phalcon\Di;

/**
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component
 */
class ElasticaClient extends Client
{
    /**
     * @var Initialize
     */
    private $init = null;
    
    /**
     * @var Di
     */
    private $di = null;
    
    /**
     * @return Initialize
     */
    public function getInitializer()
    {
        if (!$this->init)
        {
            $this->init = new Initialize($this->di);
        }
        
        return $this->init;
    }
    
    /**
     * Initialize Elasicsearch
     */
    public function initialize(Di $di)
    {
        $this->di = $di;
        
        // Initialize if index was not initialized:
        $this->getInitializer()
             ->setIndexConnection($this->getIndex(Definition::instance()->getProfileIndexName()))
             ->createIndex()
             ->createMapping();
        
        return $this;
    }
    
    /**
     * Return search path
     *
     * @return string
     */
    public function getSearchPath()
    {
        return Definition::instance()->getProfileIndexName() . '/' . Definition::instance()->getProfileName() . '/_search';
    }
    
}
