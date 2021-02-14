<?php

namespace app\models;

use yii\base\Model;

class CryptoRequestForm extends Model
{
    /** @var array */
    public $altcoinList;

    /** @var array */
    public $currencyList;

    /** @var bool */
    public $save = false;

    public function rules()
    {
        return [
            [['altcoinList', 'currencyList'], 'required'],
            [['save'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'altcoinList' => 'Альткойны:',
            'currencyList' => 'Курс альткойнов представленный в валюте:',
            'save' => 'Сохранить данные?'
        ];
    }

    /**
     * Return altcoin list
     *
     * @return array
     */
    public static function getAltcoinList(): array
    {
        $list = Altcoin::getAltcoinList();
        return array_combine($list, $list);
    }

    /**
     * Return currency list
     *
     * @return array
     */
    public static function getCurrencyList(): array
    {
        $list = Altcoin::getCurrencyList();
        return array_combine($list, $list);
    }
}