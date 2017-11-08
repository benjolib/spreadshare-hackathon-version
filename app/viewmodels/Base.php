<?php

namespace DS\ViewModel;

use DS\Component\DiInjection;
use Phalcon\Di\InjectionAwareInterface;

/**
 * Spreadshare
 *
 * Base viewmodel
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 */
abstract class Base
    extends DiInjection
    implements InjectionAwareInterface
{
}
