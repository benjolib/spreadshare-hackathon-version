<?php

namespace DS\Component\Mailer;


use DS\Component\Mailer\dto\UserMetaEmailDto;

interface Mailer
{
    public function sendWelcomeEmail(String $email, String $userName);

    public function sendNewFollowerEmail(String $email, UserMetaEmailDto $userMeta);

}