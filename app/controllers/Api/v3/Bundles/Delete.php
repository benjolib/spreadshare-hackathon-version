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
class Delete extends ActionHandler implements MethodInterface
{
    use BundleModifier;

    /**
     * @return bool
     */
    public function needsLogin()
    {
        return true;
    }

    /**
     * @return Records
     * @throws InvalidParameterException
     */
    public function process()
    {
        // fetch specific model
        $bundle = Bundles::findFirst([
            "conditions" => "id = ?0",
            "bind" => [$this->id],
        ]);
        if ($bundle) {
            $bundle->delete();
            if ($bundle->getImage()) {
                @unlink($this->getImageDiskPathByURI($bundle->getImage()));
            }
            return new Record();
        } else {
            throw new InvalidParameterException('The bundle that you want to delete does not exist.');
        }
    }
}
