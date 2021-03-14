<?php

namespace app\commands;

use app\components\api\CryptoCompare;
use app\models\Altcoin;
use app\models\AltcoinDate;
use app\models\AltcoinHistory;
use Exception;
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
        $this->fillAltcoinHistory();
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
    protected function fillAltcoinHistory(): void
    {
        $count = 0;
        $cryptoCompare = new CryptoCompare();
        foreach (Altcoin::getAltcoinList(true) as $altcoin) {
            $dates = AltcoinDate::constructDateList($altcoin);
            foreach ($dates as $humanDate => $unixDate) {
                $apiAnswer = $cryptoCompare->getPriceOnDate($altcoin, $unixDate);
                $message = ArrayHelper::getValue($apiAnswer, 'data.Message');
                $price = ArrayHelper::getValue($apiAnswer, "data.$altcoin.USD");
                $error = ArrayHelper::getValue($apiAnswer, 'error');
                if ($error || $message ) {
                    echo PHP_EOL . 'Warning! ' . $error . ' ' . $message . PHP_EOL;
                    exit('Program stopped!');
                }

                if ($apiAnswer['success'] && $price !== null) {
                    $isSave = AltcoinHistory::saveRow($altcoin, $price, $unixDate);
                    echo $isSave ? '.' : '-';
                    if ($isSave) {
                        $count++;
                    }
                }
            }
        }
        echo PHP_EOL . 'Done.  Added ' . $count . ' rows';
    }
}