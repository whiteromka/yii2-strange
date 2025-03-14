<?php

namespace app\components\api;

use app\models\Altcoin;
use app\models\AltcoinDate;
use app\models\AltcoinHistoryData;
use yii\helpers\ArrayHelper;

class CryptoLogic
{
    /** @var CryptoCompare|null  */
    private ?CryptoCompare $cryptoApi;

    public function __construct()
    {
        $this->cryptoApi = new CryptoCompare();
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function fillAltcoinHistoryData(): int
    {
        $count = 0;
        foreach (Altcoin::map(true) as $altcoinId => $altcoin) {
            $dates = AltcoinDate::constructDateList($altcoinId);
            foreach ($dates as $dateId => $unixDate) {
                $apiAnswer = $this->cryptoApi->getPriceOnDate($altcoin, $unixDate);
                list($fullMessage, $price) = $this->getApiAnswer($apiAnswer, $altcoin);
                if ($fullMessage) {
                    // Если ошибка содержит "failed to open stream" то ждем немного, и перезапускаемся по новой
                    if (strpos($fullMessage, "failed to open stream") !== false) {
                        sleep(14);
                        continue;
                    } else {
                        exit('Program stopped!');
                    }
                }
                if ($apiAnswer['success'] && $price !== null) {
                    $isSave = AltcoinHistoryData::saveRow($altcoinId, $dateId, $price);
                    if ($isSave) {
                        $count++;
                    }
                    echo $isSave ? '.' : '-';
                }
            }
        }
        return $count;
    }

    /**
     * @param array $apiAnswer
     * @param string $altcoin
     * @return array
     * @throws \Exception
     */
    protected function getApiAnswer(array $apiAnswer, string $altcoin): array
    {
        $message = ArrayHelper::getValue($apiAnswer, 'data.Message', '');
        $price = ArrayHelper::getValue($apiAnswer, "data.$altcoin.USD");
        $error = ArrayHelper::getValue($apiAnswer, 'error', '');
        $fullMessage = ($error || $message) ? ($error . ' ' . $message) : '';
        return [$fullMessage, $price];
    }
}