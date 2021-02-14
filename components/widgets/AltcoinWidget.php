<?php

namespace app\components\widgets;

use yii\base\Widget;

class AltcoinWidget extends Widget
{
    /** @var string */
    public $altcoinName;

    /** @var array */
    public $altcoinItem;

    public function run()
    {
        return $this->render('altcoin', [
            'altcoinName' => $this->altcoinName,
            'altcoinItem' => $this->altcoinItem
        ]);
    }
}