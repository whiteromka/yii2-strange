<?php

namespace app\components\notifiers;

use Yii;

class EmailNotifier implements INotifier
{
    /** @var string */
    public $to = 'whiteromka@yandex.ru';

    /** @var string */
    public $form = 'whiteromka@yandex.ru';

    /** @var string */
    public $email;

    /**
     * @param array $notificationData
     * @return bool
     */
    public function notify(array $notificationData): bool
    {
        $this->prepareEmail($notificationData);
        Yii::$app->mailer->compose()
            ->setTo($this->to)
            ->setFrom($this->form)
            ->setSubject('Уведомление по криптовалюте')
            ->setTextBody($this->email)
            ->send();
        return true;
    }

    /**
     * @param array $notificationData
     */
    protected function prepareEmail(array $notificationData): void
    {
        $message = 'Некоторые криптовалюты достиги ожидаемых вами отметок:<br>';
        foreach ($notificationData as $altcoin => $price) {
            $message .= '<b>'.$altcoin.'</b>  -  <b>' .$price. '</b> usd <br>';
        }
        $this->email = $message;
    }
}