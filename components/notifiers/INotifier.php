<?php

namespace app\components\notifiers;

interface INotifier
{
    public function notify(array $notificationData): bool;
}