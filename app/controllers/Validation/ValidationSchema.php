<?php

namespace DS\Controller\Validation;

use Phalcon\Validation;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller\Validation
 */
interface ValidationSchema
{
    /**
     * @return Validation
     */
    public static function getSchema();
    
    /**
     * Validate a set of data according to a set of rules
     *
     * @param array|object $data
     * @param object $entity
     * @return \Phalcon\Validation\Message\Group
     */
    public function validate($data = null, $entity = null);
}
