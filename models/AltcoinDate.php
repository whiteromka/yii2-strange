<?php

namespace app\models;

use Yii;
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
class AltcoinDate extends \yii\db\ActiveRecord
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

    /**
     * Gets query for [[AltcoinHistories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAltcoinHistory()
    {
        return $this->hasOne(AltcoinHistory::class, ['altcoin_date_id' => 'id']);
    }

    /**
     * To fill this table dates from $dateStart to current date
     *
     * @param string $dateStart
     * @return int
     * @throws \yii\db\Exception
     */
    public static function fill(string $dateStart)
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

        return Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['date', 'unix_date'], $data)->execute();
    }


    /**
     * @param string $altcoin
     * @return array
     */
    public static function constructDateList(string $altcoin): array
    {
        $altcoin = strtolower($altcoin);

        /** @var AltcoinHistory $altcoinHistory */
        $altcoinHistory = AltcoinHistory::find()
            ->joinWith('altcoinDate ad')
            ->where("$altcoin is not null")
            ->andWhere("altcoin_date_id is not null")
            ->orderBy('ad.date DESC')
            ->one();

        if ($altcoinHistory) {
            $dates = self::find()->orderBy('date ASC')
                ->indexBy('unix_date')
                ->select(['unix_date', 'date'])
                ->where(['>', 'id',  $altcoinHistory->altcoin_date_id])
                ->asArray()
                ->all();
        } else {
            $dates = self::find()->orderBy('date ASC')
                ->indexBy('unix_date')
                ->select(['unix_date', 'date'])
                ->asArray()
                ->all();
        }

        return ArrayHelper::map($dates,  'date', 'unix_date');
    }
}
