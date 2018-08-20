<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 22/06/18
 * Time: 15:39
 */

namespace DS\Controller\Api\Meta;

class ErrorV2 implements \JsonSerializable
{
    /**
     * @var
     */
    private $message;

    /**
     * ErrorV2 constructor.
     * @param $message
     */
    public function __construct($message)
    {
        if ($message instanceof Error) {
            $this->message = $message->getUserMessage();
        } else {
            $this->message = $message;
        }
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
