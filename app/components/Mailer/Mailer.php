<?php

namespace DS\Component\Mailer;


use DS\Component\Mailer\dto\NewSubscriberEmailDto;
use DS\Component\Mailer\dto\UserEmailDto;

interface Mailer
{
    public function sendWelcomeEmail(String $email, String $userName);

    public function sendNewFollowerEmail(String $email, UserEmailDto $userMeta);

    public function sendNewSubscriberEmail(String $email, NewSubscriberEmailDto $dto);

}