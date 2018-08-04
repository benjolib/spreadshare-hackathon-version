<?php

namespace DS\Component\Subscriptions\dto;

use DS\Model\Helper\Enum;

class SubscriptionFrequency extends Enum
{
    const DAILY = 'daily';
    const WEEKLY = 'weekly';
    const MONTHLY = 'monthly';

    public static function fromType(String $type): string
    {
        switch ($type) {
            case 'D':
                return self::DAILY;
            case 'W':
                return self::WEEKLY;
            case 'M':
                return self::MONTHLY;
            default:
                return self::WEEKLY;
        }
    }
}