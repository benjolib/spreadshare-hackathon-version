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
     * @api               {get} /locations Request all locations
     * @apiVersion        1.0.0
     * @apiName           Locations
     * @apiGroup          Public
     *
     * @apiSuccess {Object} _meta Meta object with properties total and success
     * @apiSuccess {Object[]} data Array of locations
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *      "_meta": {
     *              "total":7274,
     *              "success":true
     *          },
     *      "data": [
     *          {
     *              "id":"1",
     *              "cityId":"1",
     *              "lat":"34.983",
     *              "lng":"34.983",
     *              "locationName":"Qal eh-ye",
     *              "createdAt":1510317573
     *          },
     *          {
     *              "id":"2",
     *              "cityId":NULL,
     *              "lat":"34.983",
     *              "lng":"34.983",
     *              "locationName":"Afghanistan",
     *              "createdAt":1510317573
     *          }
     *       ]
     *      }
     *
     * @return mixed
     */
    public function process()
    {
        return new Records(Locations::getAll());
    }
    
}
