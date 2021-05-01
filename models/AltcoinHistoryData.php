<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "altcoin_history_data".
 *
 * @property int $id
 * @property int $altcoin_id Ссылка на альткойн
 * @property int $altcoin_date_id Ссылка на дату
 * @property float|null $price
 *
 * @property AltcoinDate $altcoinDate
 * @property Altcoin $altcoin
 */
class AltcoinHistoryData extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'altcoin_history_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['altcoin_id', 'altcoin_date_id'], 'required'],
            [['altcoin_id', 'altcoin_date_id'], 'integer'],
            [['price'], 'number'],
            [['altcoin_date_id'], 'exist', 'skipOnError' => true, 'targetClass' => AltcoinDate::className(), 'targetAttribute' => ['altcoin_date_id' => 'id']],
            [['altcoin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Altcoin::className(), 'targetAttribute' => ['altcoin_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'altcoin_id' => 'Altcoin ID',
            'altcoin_date_id' => 'Altcoin Date ID',
            'price' => 'Price',
        ];
    }

    /**
     * Gets query for [[AltcoinDate]].
     *
     * @return ActiveQuery
     */
    public function getAltcoinDate()
    {
        return $this->hasOne(AltcoinDate::class, ['id' => 'altcoin_date_id']);
    }

    /**
     * Gets query for [[Altcoin]].
     *
     * @return ActiveQuery
     */
    public function getAltcoin()
    {
        return $this->hasOne(Altcoin::class, ['id' => 'altcoin_id']);
    }

    /**
     * @param int $altcoinId
     * @param int $dateId
     * @param float $price
     * @return bool
     */
    public static function saveRow(int $altcoinId, int $dateId, float $price): bool
    {
        $history = new self();
        $history->altcoin_id = $altcoinId;
        $history->altcoin_date_id = $dateId;
        $history->price = $price;
        return $history->save();
    }

    /**
     * @param string $altcoin
     * @return array
     * @throws Exception
     */
    public function getDataCharts(string $altcoin): array
    {
        $sql = "
        select
            DATE_FORMAT(ad.date, '%d.%m.%Y') date,
            ahd.price value
        from altcoin_history_data ahd
            join altcoin_date ad on ahd.altcoin_date_id = ad.id
            where altcoin_id = (select a.id from altcoin a where a.name = :altcoin)
        ";
        $data = Yii::$app->db->createCommand($sql, [':altcoin' => $altcoin])->queryAll();
        return [$altcoin => $data];
    }

    /**
     * @return array
     */
    public function getLastPrices(): array
    {
        $prices = [];
        foreach (Altcoin::map() as $altcoinId => $altcoin) {
            $prices[$altcoin] = AltcoinHistoryData::find()
                ->select(['price'])
                ->where(['altcoin_id' => $altcoinId])
                ->orderBy('altcoin_date_id DESC')
                ->scalar();
        }
        return $prices;
    }
}
