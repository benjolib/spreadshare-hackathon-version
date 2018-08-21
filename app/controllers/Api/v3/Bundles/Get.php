<?php

namespace DS\Controller\Api\v3\Bundles;

use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Record;
use DS\Controller\Api\Meta\Records;
use DS\Controller\Api\MethodInterface;
use DS\Model\Bundles;
use DS\Exceptions\InvalidParameterException;

/**
 *
 * Spreadshare
 *
 * @author            Vladislav Klimenko
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
        return true;
    }

    /**
     * @return Records
     */
    public function process()
    {
        if ($this->id) {
            // fetch specific model
            $bundle = Bundles::findFirst([
                "conditions" => "id = ?0",
                "columns" => "id, title, image",
                "bind" => [$this->id],
            ]);
            if ($bundle) {
                return new Record($bundle);
            } else {
                throw new InvalidParameterException('The bundle that you want to get does not exist.');
            }
        } else {
            // fetch all models
            /** @var Bundles[] $bundles */
            $bundles = Bundles::find(['order' => 'id ASC']);
            $result = array();
            foreach ($bundles as $bundle) {
                $result[] = array_merge($bundle->toArray(['id','title']), ['image' => $bundle->getImage()]);
            }
            return new Records($result);
        }
    }
}
