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


class UserTableSubscribed extends AbstractEvent
{

    public static function after(int $userId, int $tableId, String $type)
    {
        $user = User::findFirstById($userId);
        $table = Tables::findFirstById($tableId);

        self::createUserNotification($userId, $tableId, $table, $user);
        self::createTableLog($userId, $tableId, $user);
        self::changeTableStats($tableId);
        self::subscribeForEmailNotifications($user, $tableId, $type);
        self::sendNewSubscriberEmail($user, $table);
    }

    private static function subscribeForEmailNotifications(User $subscriber, int $tableId, String $type)
    {
        ServiceManager::instance(self::getDI())
            ->getSubscriptionsService()
            ->subscribeForEmailNotifications($subscriber->getId(),
                $tableId, $subscriber->getEmail(),
                SubscriptionFrequency::fromType($type));
    }

    private static function sendNewSubscriberEmail(User $subscriber, Tables $table)
    {
        $tableOwner = User::findFirstById($table->getOwnerUserId());
        $domain = ServiceManager::instance(self::getDi())->getConfig()['domain'];
        $baseUri = "https://$domain";

        $subscriberDto = new UserEmailDto($baseUri);
        $subscriberDto->withHandle($subscriber->getHandle())
            ->setName($subscriber->getName())
            ->setImageLink($subscriber->getImage())
            ->setTagLine($subscriber->getTagline());

        $stream = new StreamEmailDto($baseUri);
        $stream
            ->setName($table->getTitle())
            ->withSlug($table->getSlug());

        $dto = new NewSubscriberEmailDto($subscriberDto, $stream);

        ServiceManager::instance(self::getDI())
            ->getMailService()
            ->sendNewSubscriberEmail($tableOwner->getEmail(), $dto);
    }

    public static function createUserNotification(int $userId, int $tableId, Tables $table, User $user)
    {
        $userNotification = new UserNotifications;
        $userNotification
            ->setUserId($table->getOwnerUserId())
            ->setNotificationType(UserNotificationType::TableSubscribed)
            ->setSourceUserId($userId)
            ->setSourceTableId($tableId)
            ->setText(sprintf('Subscribed to %s', $table->getTitle()))
            ->setPlaceholders(
                json_encode(
                    [
                        $user->getName(),
                        $table->getTitle(),
                    ]
                )
            )
            ->create();
    }

    public static function createTableLog(int $userId, int $tableId, User $user)
    {
        $tableLog = new TableLog();
        $tableLog
            ->setUserId($userId)
            ->setTableId($tableId)
            ->setLogType(TableLogType::Subscribed)
            ->setText('Subscribed this Stream.')
            ->setPlaceholders(
                json_encode(
                    [
                        $user->getId(),
                        $user->getName(),
                    ]
                )
            )
            ->create();
    }

    public static function changeTableStats(int $tableId)
    {
        $tableStats = TableStats::findByFieldValue('tableId', $tableId);
        if (!$tableStats) {
            $tableStats = new TableStats;
        }
        $tableStats->setSubscriberCount($tableStats->getSubscriberCount() + 1)->save();
    }

}