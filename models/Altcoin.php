<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "altcoin".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $full_name
 * @property int $sort
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property AltcoinHistory[] $altcoinHistories
 */
class Altcoin extends ActiveRecord
{
    const BTC = 'btc';   # 1
    const ETH = 'eth';   # 2
    const LTC = 'ltc';   # 3
    const XRP = 'xrp';   # 4 XRP ripl
    const ATOM = 'atom'; # 5 Cosmos
    const XMR = 'xmr';   # 6 Monero
    const BNB = 'bnb';   # 7 Binance Coin
    const ZEC = 'zec';   # 10 Zcash
    const ADA = 'ada';   # 11 cardano
    // polkadot DOT
    // maker MKR
    // Synthetix SNX
    // Compound COMP

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

    /** @var int */
    public $start_unixtime;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'full_name'], 'string', 'max' => 255],
            [['sort', '$start_unixtime'], 'integer'],
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
            'name' => 'Имя',
            'full_name' => 'Полное имя',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'start_unixtime' => 'Unixtime рождение'
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
     * @param bool $capitalize
     * @return array
     */
    public static function map(bool $capitalize = false): array
    {
        $altcoins = self::find()->select(['id', 'name'])->all();
        $map = ArrayHelper::map($altcoins, 'id', 'name');
        if ($capitalize) {
            return $map;
        }
        return array_map('strtolower', $map);
    }

    /**
     * @return array
     */
    public static function getAltcoinListId(): array
    {
        return self::find()->select(['id'])->column();
    }

    /**
     * @param bool $capitalize
     * @return array
     */
    public static function getAltcoinList(bool $capitalize = false): array
    {
        $altcoins = self::find()->select(['name'])->column();
        if ($capitalize) {
            return $altcoins;
        }
        return array_map('strtolower', $altcoins);
    }

    /**
     * @return array
     */
    public static function getCurrencyList(): array
    {
        return [self::RUB, self::USD, self::EUR];
    }
}