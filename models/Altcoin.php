<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
class Altcoin extends ActiveRecord
{
    const BTC = 'btc';
    const ETH = 'eth';
    const LTC = 'ltc';
    const XRP = 'xrp';   # XRP
    const ATOM = 'atom'; # Cosmos
    const XMR = 'xmr';   # Monero
    const BNB = 'bnb';   # Binance Coin

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
     * @return ActiveQuery
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
     * @param bool $capitalize
     * @return array
     */
    public static function getAltcoinList(bool $capitalize = false): array
    {
        if ($capitalize) {
            return [
                strtoupper(self::BTC),
                strtoupper(self::ETH),
                strtoupper(self::LTC),
                strtoupper(self::XRP),
                strtoupper(self::ATOM),
                strtoupper(self::XMR),
                strtoupper(self::BNB)
            ];
        }
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