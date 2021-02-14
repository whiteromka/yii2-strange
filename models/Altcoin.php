<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "altcoin".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $full_name
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property AltcoinHistory[] $altcoinHistories
 */
class Altcoin extends \yii\db\ActiveRecord
{
    const BTC = 'BTC';
    const ETH = 'ETH';
    const LTC = 'LTC';
    const XRP = 'XRP';   # XRP
    const ATOM = 'ATOM'; # Cosmos
    const XMR = 'XMR';   # Monero
    const BNB = 'BNB';   # Binance Coin

    const BTC_ID = 1;
    const ETH_ID = 2;
    const LTC_ID = 3;
    const XRP_ID = 4;
    const ATOM_ID = 5;
    const XMR_ID = 6;
    const BNB_ID = 7;

    const USD = 'USD';
    const RUB = 'RUB';
    const EUR = 'EUR';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'altcoin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'full_name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['full_name'], 'unique'],
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
            'full_name' => 'Full Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[AltcoinHistories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAltcoinHistories()
    {
        return $this->hasMany(AltcoinHistory::class, ['altcoin_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getAltcoinListId(): array
    {
        return [self::BTC_ID, self::ETH_ID, self::LTC_ID, self::XRP_ID, self::ATOM_ID, self::XMR_ID, self::BNB_ID];
    }

    /**
     * @return array
     */
    public static function getAltcoinList(): array
    {
        return [self::BTC, self::ETH, self::LTC, self::XRP, self::ATOM, self::XMR, self::BNB];
    }

    /**
     * @return array
     */
    public static function getCurrencyList(): array
    {
        return [self::RUB, self::USD, self::EUR];
    }
}