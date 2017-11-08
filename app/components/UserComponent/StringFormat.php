<?php
namespace DS\Component\UserComponent;

use Phalcon\Mvc\User\Component;
use DS\Component\PrettyDateTime;

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
class StringFormat
    extends Component
{
    /**
     * @var PrettyDateTime
     */
    private $date = null;

    /**
     * @return $this
     */
    public function init()
    {
        if (!$this->date)
        {
            $this->date = new PrettyDateTime();
        }

        return $this;
    }

    /**
     * @return StringFormat
     */
    public static function factory()
    {
        return (new self())->init();
    }

    /**
     * @param $date
     *
     * @return string
     * @throws \Exception
     */
    public function prettyDay($date)
    {
        return $this->date->day(new \DateTime($date));
    }

    /**
     * @param string $date
     *
     * @return string
     * @throws \Exception
     */
    public function prettyDate($date)
    {
        return $this->date->parse(new \DateTime($date));
    }

}
