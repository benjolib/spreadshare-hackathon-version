<?php

namespace DS\Component\Subscriptions;

interface SubscriptionsService
{
    public function subscribeForEmailNotifications(int $userId, int $tableId, String $email, String $frequency);
    public function unsubscribeFromEmailNotifications(int $userId, int $tableId);
}