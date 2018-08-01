<?php

namespace DS\Component\Mailer;


interface Mailer
{
    public function sendWelcomeEmail(String $email, String $userName);

}