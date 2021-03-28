<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "altcoin_history".
 *
 * @property int $id
 * @property int $altcoin_date_id
 * @property float|null $btc
 * @property float|null $eth
 * @property float|null $ltc
 * @property float|null $xrp
 * @property float|null $atom
 * @property float|null $xmr
 * @property float|null $bnb
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property AltcoinDate $altcoinDate
 */
class AltcoinHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'altcoin_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['altcoin_date_id'], 'integer'],
            [['btc', 'eth', 'ltc', 'xrp', 'atom', 'xmr', 'bnb'], 'number'],
            [['date', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAltcoinDate()
    {
        return $this->hasOne(AltcoinDate::class, ['id' => 'altcoin_date_id']);
    }

    /**
     * @param string|null $altcoin
     * @return array
     * @throws Exception
     */
    public function getDataCharts(string $altcoin = null): array
    {
        $data = $this->sqlDataCharts($altcoin);
        $result = [];
        foreach (Altcoin::getAltcoinList() as $altcoin) {
            if (!isset($data[0][$altcoin])) {
                continue;
            }
            foreach ($data as $row) {
                $result[$altcoin][] = [
                    'value' => $row[$altcoin],
                    'date' => $row['date']
                ];
            }
        }
        return $result;
    }

    /**
     * @param string|null $altcoin
     * @return array
     * @throws Exception
     */
    protected function sqlDataCharts(string $altcoin = null): array
    {
        $db = Yii::$app->db;
        if ($altcoin) {
            if (in_array($altcoin, Altcoin::getAltcoinList())) {
                $sql = "SELECT DATE_FORMAT(ad.date, '%d.%m.%Y') as date, $altcoin
                FROM altcoin_history as ah
                LEFT JOIN altcoin_date ad ON ah.altcoin_date_id = ad.id";
            } else {
                throw new Exception('Error in ' . __METHOD__); // ToDo Sql injection
            }
        } else {
            $sql = "SELECT DATE_FORMAT(ad.date, '%d.%m.%Y') as date,
            ah.btc, ah.eth, ah.ltc, ah.xrp, ah.atom, ah.xmr, ah.bnb
                FROM altcoin_history as ah
            LEFT JOIN altcoin_date ad ON ah.altcoin_date_id = ad.id";
        }
        return $db->createCommand($sql)->queryAll();
    }

    /**
     * @param string $altcoin
     * @param float $price
     * @param int $unixDate
     * @return bool
     */
    public static function saveRow(string $altcoin, float $price, int $unixDate): bool
    {
        $columnAltcoin = strtolower($altcoin);

        $altcoinDateId = AltcoinDate::find()->select('id')->where(['unix_date' => $unixDate])->scalar();
        $altcoinHistory = AltcoinHistory::find()->where(['altcoin_date_id'=>$altcoinDateId])->one();
        if (!$altcoinHistory) {
            $altcoinHistory = new AltcoinHistory();
        }
        $altcoinHistory->altcoin_date_id = $altcoinDateId;
        $altcoinHistory->$columnAltcoin = $price;
        return $altcoinHistory->save(false);
    }
}