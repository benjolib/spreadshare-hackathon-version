<?php

namespace DS\Component\Subscriptions\dto;

use DS\Model\Helper\Enum;

class SubscriptionChannel extends Enum
{
    const EMAIL = 'email';
    const RSS = 'rss';

}