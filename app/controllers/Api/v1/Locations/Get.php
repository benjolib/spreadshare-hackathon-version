<?php

namespace DS\Controller\Api\v1\Locations;

use DS\Api\Locations;
use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Records;
use DS\Controller\Api\MethodInterface;

/**
 *
 * Spreadshare
 *
 * @author            Dennis Stücken
 * @license           proprietary
 * @copyright         Spreadshare
 * @link              https://www.spreadshare.co
 *
 * @version           $Version$
 * @package           DS\Controller
 *
 */
class Get extends ActionHandler implements MethodInterface
{
    private $searchMinimum = 2;
    
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
     * @api               {get} /api/v1/locations Request all locations
     * @apiParam          {String} q Search term
     * @apiVersion        1.0.0
     * @apiName           Locations
     * @apiGroup          Public
     *
     * @apiSuccess {Object} _meta Meta object
     * @apiSuccess {int} _meta.total total number of items included in this response
     * @apiSuccess {bool} _meta.success Defines whether the request had any errors
     * @apiSuccess {Object[]} data Array of locations
     * @apiSuccess {string} data.id Id of location
     * @apiSuccess {string} data.locationName Name of location
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "_meta": {
     *              "total": 3,
     *              "success": true
     *          },
     *          "data": [
     *              {
     *                  "id": "1",
     *                  "locationName": "Berlin",
     *              },
     *              {
     *                  "id": "2",
     *                  "locationName": "Germany",
     *              },
     *              {
     *                  "id": "3",
     *                  "locationName": "Cologne",
     *              }
     *          ]
     *      }
     *
     * @return mixed
     */
    public function process()
    {
        $query = $this->request->get('q', null, null);
        
        if ($query === null || strlen($query) < $this->searchMinimum)
        {
            throw new \InvalidArgumentException(sprintf('Give at least %d characters.', $this->searchMinimum));
        }
        
        return new Records(Locations::searchLocationByName($query));
    }
    
}
