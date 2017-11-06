<?php
namespace DS\Component;

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
abstract class DiInjection
    implements Di\InjectionAwareInterface
{
    use \DS\Traits\DiInjection;
}
