<?php

namespace DS\Events\User;

use DS\Component\Mailer\dto\NewSubscriberEmailDto;
use DS\Component\Mailer\dto\StreamEmailDto;
use DS\Component\Mailer\dto\UserEmailDto;
use DS\Component\ServiceManager;
use DS\Component\Subscriptions\dto\SubscriptionFrequency;
use DS\Events\AbstractEvent;
use DS\Model\DataSource\TableLogType;
use DS\Model\DataSource\UserNotificationType;
use DS\Model\TableLog;
use DS\Model\Tables;
use DS\Model\TableStats;
use DS\Model\User;
use DS\Model\UserNotifications;

class UserTableSubscriptionChanged extends AbstractEvent
{

    public static function after(int $userId, int $tableId, String $type)
    {
        $user = User::findFirstById($userId);
        self::subscribeForEmailNotifications($user, $tableId, $type);
    }

    private static function subscribeForEmailNotifications(User $subscriber, int $tableId, String $type)
    {
        ServiceManager::instance(self::getDI())
            ->getSubscriptionsService()
            ->subscribeForEmailNotifications($subscriber->getId(),
                $tableId, $subscriber->getEmail(),
                SubscriptionFrequency::fromType($type));
    }

}