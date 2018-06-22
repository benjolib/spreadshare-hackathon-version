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
    private $message;

    private function __construct($message)
    {
        $this->message = $message;
    }

    public static function fromErrorV1(Error $error)
    {
        $ev2 = new self($error->getUserMessage());
        return $ev2;
    }

    public function jsonSerialize()
    {
        return [
            "sucess" => false,
            "message" => $this->message,
        ];
    }
}