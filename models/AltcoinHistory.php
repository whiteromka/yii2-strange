<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "altcoin_history".
 *
 * @property int $id
 * @property int|null $altcoin_id
 * @property float|null $rub
 * @property string|null $rub_last_changed
 * @property float|null $usd
 * @property string|null $usd_last_changed
 * @property float|null $eur
 * @property string|null $eur_last_changed
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property Altcoin $altcoin
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
            [['altcoin_id'], 'integer'],
            [['rub', 'usd', 'eur'], 'number'],
            [['rub_last_changed', 'usd_last_changed', 'eur_last_changed', 'created_at', 'updated_at'], 'safe'],
            [['rub_last_changed'], 'safe'],
            [['usd_last_changed'], 'safe'],
            [['eur_last_changed'], 'safe'],
            [['altcoin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Altcoin::class, 'targetAttribute' => ['altcoin_id' => 'id']],
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
            'rub' => 'Rub',
            'rub_last_changed' => 'Rub Last Changed',
            'usd' => 'Usd',
            'usd_last_changed' => 'Usd Last Changed',
            'eur' => 'Eur',
            'eur_last_changed' => 'Eur Last Changed',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Altcoin]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAltcoin()
    {
        return $this->hasOne(Altcoin::class, ['id' => 'altcoin_id']);
    }

    /**
     * @param array $data
     * @return array
     */
    public static function saveData(array $data): array
    {
        foreach ($data as $altcoinName => $dataPrice) {
            $date = date('Y-m-d H:i:s');
            $altcoinHistory = new AltcoinHistory();
            $altcoinID = Altcoin::find()->select('id')->asArray()->where(['name' => $altcoinName])->scalar();
            $altcoinHistory->altcoin_id = $altcoinID;
            foreach ($dataPrice as $currencyName => $price ) {
                $currencyName = strtolower($currencyName);
                $altcoinHistory->$currencyName = $price;
                $lastChanged = $currencyName . '_last_changed';
                $altcoinHistory->$lastChanged = $date;
            }
            if (!$altcoinHistory->save()) {
                $error = $altcoinHistory->firstErrors;
                $key = array_key_first($error);
                return ['success' => false, 'error' => $error[$key]];
            }
        }
        return ['success' => true];
    }
}