<?php

namespace app\commands;

use app\components\api\CryptoLogic;
use app\components\CryptoWatcher;
use app\models\AltcoinDate;
use app\models\AltcoinHistory;
use app\models\AltcoinHistoryData;
use Exception;
use Yii;

class CryptoController extends BaseController
{
    /**
     * Construct altcoin_date since 2022-01-01 to current date, and try to save this
     * Trying to get prices for altcoins for alctoin_history table, and try to save this
     * Заполнит даты в altcoin_date и начнет запонять altcoin_history_data через АПИ
     *
     * php yii crypto/fill
     *
     * @throws \yii\db\Exception
     */
    public function actionFill(): void
    {
        $this->fillAltcoinDate();
        $this->fillAltcoinHistoryData();
    }

    /**
     * Delete all from altcoin_date
     *
     * php yii crypto/delete-all-altcoin-date
     */
    public function actionDeleteAllAltcoinDate()
    {
        $count = AltcoinDate::deleteAll();
        echo PHP_EOL . AltcoinDate::tableName() .  ' truncated! ' . $count . ' rows deleted!' . PHP_EOL;
    }

    /**
     * Just add dates in AltcoinDate from '2022-01-01' to current date
     * Просто сгенерирует даты в AltcoinDate от '2022-01-01' до текущей даты
     *
     * php yii crypto/fill-altcoin-date
     *
     * @throws \yii\db\Exception
     */
    public function actionFillAltcoinDate(): void
    {
        $altconDate = new AltcoinDate();
        $count = $altconDate->fill('2022-01-01'); // '2022-01-01'
        echo PHP_EOL . 'Added ' . $count . ' rows in altcoin_date table.'
            . PHP_EOL . 'Operation in progress ... (do not press anything)' . PHP_EOL;
    }

    /**
     * php yii crypto/fill-altcoin-history-data
     *
     * @throws Exception
     */
    public function actionFillAltcoinHistoryData(): void
    {
        $saved = (new CryptoLogic())->fillAltcoinHistoryData();
        echo PHP_EOL . 'Added - ' . $saved;
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
            exit (PHP_EOL . 'altcoinDate not found by toUnixtime in ' . __METHOD__ );
        }
        $rows = $this->createRowsAltcoinHistoryData($altcoinId, $altcoinDate, $history);
        $attributes = ['altcoin_id', 'altcoin_date_id', 'price'];
        $successCount = Yii::$app->db->createCommand()
            ->batchInsert(AltcoinHistoryData::tableName(), $attributes, $rows)->execute();
        $this->setSuccessCount($successCount);
        $this->showActionInfo(true, false);
    }

    /**
     * Check and notify user about rates
     */
    public function actionWatcher(): void
    {
        (new CryptoWatcher())->prepareWatchers()->prepareNotificationData()->notify();
    }

    /**
     * @param int $altcoinId
     * @param AltcoinDate $altcoinDate
     * @param AltcoinHistoryData|null $history
     * @return array
     */
    protected function createRowsAltcoinHistoryData(int $altcoinId,  AltcoinDate $altcoinDate, AltcoinHistoryData $history = null): array
    {
        $dateId = $this->calcDateId($history, $altcoinDate);
        $finalDateId = (int)$altcoinDate->id;
        $rows = [];
        for ($i = $dateId; $i <= $finalDateId; $i++) {
            $rows[] = [$altcoinId, $i, 0];
        }
        return $rows;
    }

    /**
     * @param AltcoinDate $altcoinDate
     * @param AltcoinHistoryData $history
     * @return int
     */
    protected function calcDateId(AltcoinDate $altcoinDate, AltcoinHistoryData $history = null): int
    {
        if ($history && $altcoinDate && ($history->altcoin_date_id < $altcoinDate->id)) {
            $dateId = 1 + (int)$history->altcoin_date_id;
        } else {
            $dateId = 1;
        }
        return $dateId;
    }
}