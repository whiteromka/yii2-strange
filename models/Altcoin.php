<?php

namespace app\models;

use app\components\api\CryptoCompare;
use Exception;
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
 * @property AltcoinWatchers[] $altcoinWatchers
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
    const ZEC = 'zec';   # 10 Zcash 1477688400
    const ADA = 'ada';   # 11 cardano
    const DOT = 'dot';   # 13 polkadot
    const RVN = 'rvn';   # ..  ... 1523998800
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
            [['name'], 'filter', 'filter' => 'strtoupper', 'skipOnArray' => true],
            [['sort', 'start_unixtime'], 'integer'],
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
            'start_unixtime' => 'Unixtime рождения'
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
     * @return ActiveQuery
     */
    public function getAltcoinWatchers()
    {
        return $this->hasMany(AltcoinWatcher::class, ['altcoin_id' => 'id']);
    }

    /**
     * Returns map id - name from all records from altcoin
     * Вернет карту id - name по всем записям из тбл altcoin
     *
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
        return $capitalize ? $altcoins : array_map('strtolower', $altcoins);
    }

    /**
     * @return array
     */
    public static function getCurrencyList(): array
    {
        return [self::RUB, self::USD, self::EUR];
    }

    /**
     * @return array
     * @throws Exception
     */
    public function addNew(): array
    {
        $cryptoCompare = new CryptoCompare();
        $apiAnswer = $cryptoCompare->getPriceOnDate($this->name, $this->start_unixtime);
        if ($apiAnswer['success']) {
            $this->save(false);
            $dateId = AltcoinDate::find()->select(['id'])->where(['unix_date' => $this->start_unixtime])->scalar();
            AltcoinHistoryData::saveRow($this->id, $dateId, $apiAnswer['data'][$this->name]['USD']);
            return ['success' => true];
        }
        return [
            'success' => false,
            'error' => ArrayHelper::getValue($apiAnswer, 'data.Message')
        ];
    }
}