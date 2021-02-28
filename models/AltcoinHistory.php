<?php

namespace app\models;

use Yii;

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
 * @property Altcoin $altcoin
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
     * @return \yii\db\ActiveQuery
     */
    public function getAltcoinDate()
    {
        return $this->hasOne(AltcoinDate::class, ['id' => 'altcoin_date_id']);
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