<?php

namespace DS\Controller\Api\v1\Search;

use DS\Component\ServiceManager;
use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Record;
use DS\Controller\Api\MethodInterface;
use Elastica\Query\QueryString;

/**
 *
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
class Get extends ActionHandler implements MethodInterface
{
    /**
     * @return bool
     */
    public function needsLogin()
    {
        return false;
    }
    
    /**
     * Process Get Method
     *
     * @return mixed
     */
    public function process()
    {
        // Query String
        $query = $this->request->get('query');
        
        if (!$query)
        {
            return new Record('Query string is required');
        }
        
        // getClient
        $elasticaClient = ServiceManager::instance()->getElasticSearch();
        // Load index
        $elasticaIndex = $elasticaClient->getIndex('tables');
        // Get type
        $elasticaType = $elasticaIndex->getType('table');
        
        $queryString = new QueryString($query);
        
        $resultSet = $elasticaType->search($queryString);
        
        return new Record($resultSet->getResponse()->getData());
        
    }
    
}
