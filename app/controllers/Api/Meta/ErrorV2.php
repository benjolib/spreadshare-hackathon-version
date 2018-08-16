<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 22/06/18
 * Time: 15:39
 */

namespace DS\Controller\Api\Meta;


class ErrorV2
{
    /**
     * @var
     */
    private $message;

    /**
     * ErrorV2 constructor.
     * @param $message
     */
    private function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * @param Error $error
     * @return ErrorV2
     */
    public static function fromErrorV1(Error $error)
    {
        $ev2 = new self($error->getUserMessage());
        return $ev2;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            "sucess" => false,
            "message" => $this->message,
        ];
    }
}
