<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $district
 * @property int|null $population
 * @property string|null $subject
 * @property float|null $lat
 * @property float|null $lon
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['population'], 'integer'],
            [['lat', 'lon'], 'number'],
            [['name', 'district', 'subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'district' => 'District',
            'population' => 'Population',
            'subject' => 'Subject',
            'lat' => 'Lat',
            'lon' => 'Lon',
        ];
    }

    /**
     * Return random city name
     *
     * @return string
     */
    public static function getRandomCity() : string
    {
        $cache = Yii::$app->cache;
        $cityNameList = $cache->getOrSet('cityNameList', function() {
           return self::find()->select('name')->asArray()->column();
        }, 100);

        $randomKey = array_rand($cityNameList);
        return $cityNameList[$randomKey];
    }
}
