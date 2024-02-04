<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "altcoin_date".
 *
 * @property int $id
 * @property string|null $date
 * @property int|null $unix_date
 *
 * @property AltcoinHistory $altcoinHistory
 */
class AltcoinDate extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'altcoin_date';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['unix_date'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'unix_date' => 'Unix Date',
        ];
    }

//    /**
//     * Gets query for [[AltcoinHistories]].
//     *
//     * @return ActiveQuery
//     */
//    public function getAltcoinHistory()
//    {
//        return $this->hasOne(AltcoinHistory::class, ['altcoin_date_id' => 'id']);
//    }

    /**
     * To fill this table dates from $dateStart to current date
     *
     * @param string $dateStart
     * @return int
     * @throws Exception
     */
    public /*static*/ function fill(string $dateStart)
    {
        /** @var self $lastDateTable */
        $lastDateTable = self::find()->orderBy('date DESC')->one();
        if ($lastDateTable) {
            $unixDateStart = strtotime($lastDateTable->date . '+1 day');
            $dateStart = date('Y-m-d', $unixDateStart);
        }

        $data = [];

        $endDate = date('Y-m-d');
        $currentDate = $dateStart;
        while ($currentDate < $endDate) {
            $data[] = [$currentDate, strtotime($currentDate)];
            $nextDate = strtotime($currentDate . '+1 day');
            $currentDate = date('Y-m-d', $nextDate);
        }

        return Yii::$app->db->createCommand()
            ->batchInsert(self::tableName(), ['date', 'unix_date'], $data)->execute();
    }

    /**
     * @param int $altcoinId
     * @return array
     */
    public static function constructDateList(int $altcoinId): array
    {
        /** @var AltcoinHistoryData $altcoinHistoryData */
        $altcoinHistoryData = AltcoinHistoryData::find()
            ->joinWith('altcoinDate ad')
            ->where(['altcoin_id' => $altcoinId])
            ->andWhere("altcoin_date_id is not null")
            ->orderBy('ad.date DESC')
            ->one();

        if ($altcoinHistoryData) {
            $dates = self::find()->orderBy('date ASC')
                ->where(['>', 'unix_date',  $altcoinHistoryData->altcoinDate->unix_date])
                ->asArray()
                ->all();
        } else {
            $dates = self::find()->orderBy('date ASC')->asArray()->all();
        }

        return ArrayHelper::map($dates,  'id', 'unix_date');
    }
}
