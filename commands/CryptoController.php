<?php

namespace app\commands;

use app\components\api\CryptoCompare;
use app\components\CryptoWatcher;
use app\models\Altcoin;
use app\models\AltcoinDate;
use app\models\AltcoinHistory;
use app\models\AltcoinHistoryData;
use Exception;
use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class CryptoController extends Controller
{
    /**
     * Construct altcoin_date since 2011-01-01 to current date, and try to save this
     * Trying to get prices for altcoins for alctoin_history table, and try to save this
     *
     * @throws \yii\db\Exception
     */
    public function actionFill(): void
    {
        $this->fillAltcoinDate();
        $this->fillAltcoinHistoryData();
    }

    /**
     * @throws \yii\db\Exception
     */
    protected function fillAltcoinDate(): void
    {
        $altconDate = new AltcoinDate();
        $count = $altconDate->fill('2011-01-01');
        echo PHP_EOL . 'Added ' . $count . ' rows in altcoin_date table.'
            . PHP_EOL . 'Operation in progress ... (do not press anything)' . PHP_EOL;
    }

    /**
     * @throws Exception
     */
    protected function fillAltcoinHistoryData(): void
    {
        $count = 0;
        $cryptoCompare = new CryptoCompare();

        foreach (Altcoin::map(true) as $altcoinId => $altcoin) {
            $dates = AltcoinDate::constructDateList($altcoinId);
            foreach ($dates as $dateId => $unixDate) {
                $apiAnswer = $cryptoCompare->getPriceOnDate($altcoin, $unixDate);
                $message = ArrayHelper::getValue($apiAnswer, 'data.Message');
                $price = ArrayHelper::getValue($apiAnswer, "data.$altcoin.USD");
                $error = ArrayHelper::getValue($apiAnswer, 'error');
                if ($error || $message ) {
                    echo PHP_EOL . 'Warning! ' . $error . ' ' . $message . PHP_EOL;
                    exit('Program stopped!');
                }

                if ($apiAnswer['success'] && $price !== null) {
                    $isSave = AltcoinHistoryData::saveRow($altcoinId, $dateId, $price);
                    echo $isSave ? '.' : '-';
                    if ($isSave) {
                        $count++;
                    }
                }
            }
        }
        echo PHP_EOL . 'Done.  Added ' . $count . ' rows';
    }

    /**
     * @param int $altcoinId
     * @param int $toUnixtime
     * @throws \yii\db\Exception
     */
    public function actionSetPriceZero(int $altcoinId, int $toUnixtime): void
    {
        /** @var AltcoinHistoryData $history */
        $history = AltcoinHistoryData::find()
            ->where(['altcoin_id' => $altcoinId])
            ->orderBy('altcoin_date_id DESC')
            ->one();

        /** @var AltcoinDate $altcoinDate */
        $altcoinDate = AltcoinDate::findOne(['unix_date' => $toUnixtime]);
        if (!$altcoinDate) {
            exit (PHP_EOL . '$altcoinDate not found by $toUnixtime');
        }

        if ($history && $altcoinDate && ($history->altcoin_date_id < $altcoinDate->id)) {
            $dateId = 1 + (int)$history->altcoin_date_id;
        } elseif (!$history && $altcoinDate) {
            $dateId = 1;
        }
        $finalDateId = (int)$altcoinDate->id;
        $rows = [];
        for ($i = $dateId; $i <= $finalDateId; $i++) {
            $rows[] = [$altcoinId, $i, 0];
        }
        $attributes = ['altcoin_id', 'altcoin_date_id', 'price'];
        echo PHP_EOL . 'Added rows: ' . Yii::$app->db->createCommand()
                ->batchInsert(AltcoinHistoryData::tableName(), $attributes, $rows)->execute();

    }

    /**
     * Check and notify user about rates
     */
    public function actionWatcher(): void
    {
        (new CryptoWatcher())->prepareWatchers()->prepareNotificationData()->notify();
    }
}