<?php

namespace app\components;

use app\components\api\CryptoCompare;
use app\components\notifiers\EmailNotifier;
use app\components\notifiers\INotifier;
use app\models\AltcoinWatcher;
use yii\helpers\ArrayHelper;
use Yii;

class CryptoWatcher
{
    /** @var array */
    protected $watchers;

    /** @var array - Пример: ['BTC' => 65000, 'LTC' => 650] */
    protected $notificationData;

    /** @var INotifier */
    protected $notifier;

    /**
     * @return array
     */
    public function getWatchers(): array
    {
        return $this->watchers;
    }

    /**
     * @return array
     */
    public function getNotificationData(): array
    {
        return $this->notificationData;
    }

    public function __construct()
    {
        $this->notifier = new EmailNotifier();
    }

    /**
     * @param INotifier $notifier
     */
    public function setNotifier(INotifier $notifier): void
    {
        $this->notifier = $notifier;
    }

    /**
     * @return $this
     * @throws \yii\db\Exception
     */
    public function prepareWatchers()
    {
        $sql = '
            SELECT 
                a.id,
                a.name,
                aw.wish_price,
                aw.expectation
            FROM altcoin_watcher aw
            LEFT JOIN altcoin a ON aw.altcoin_id = a.id
        ';
        $this->watchers = Yii::$app->db->createCommand($sql)->queryAll();
        return $this;
    }

    /**
     * @return CryptoWatcher
     */
    public function prepareNotificationData(): self
    {
        $altcoins = array_unique(ArrayHelper::getColumn($this->watchers , 'name'));
        $apiAnswer = (new CryptoCompare())->getPrettyMultiPrice($altcoins);
        if (!$apiAnswer['success']) {
            return $this;
        }

        $dataPrices = $apiAnswer['data'];
        $this->resetNotificationData($dataPrices);
        return $this;
    }

    /**
     * @param array $dataPrices
     */
    protected function resetNotificationData(array $dataPrices): void
    {
        foreach ($this->watchers as $watcher) {
            $currentAltcoin = $watcher['name'];
            $wishPrice = $watcher['wish_price'];
            $actualPrice = $dataPrices[$currentAltcoin];

            if ($watcher['expectation'] == AltcoinWatcher::EXPECTATION_UP) {
                if ($actualPrice >= $wishPrice) {
                    $this->notificationData[$currentAltcoin] = $actualPrice;
                }
            } else {
                if ($actualPrice <= $wishPrice) {
                    $this->notificationData[$currentAltcoin] = $actualPrice;
                }
            }
        }
    }

    /**
     * @return int
     */
    public function notify(): bool
    {
        if (!$this->notificationData) {
            return false;
        }
        return $this->notifier->notify($this->notificationData);
    }
}