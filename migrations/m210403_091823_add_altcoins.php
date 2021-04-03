<?php

use app\models\Altcoin;
use yii\db\Migration;

/**
 * Class m210403_091823_add_altcoins
 */
class m210403_091823_add_altcoins extends Migration
{
    public $list = ['ZEC', 'ADA'];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach ($this->list as $coin) {
            $altcoin = new Altcoin();
            $altcoin->name = $coin;
            $altcoin->save(false);
        }

        $this->addColumn('altcoin_history', 'zec', $this->float()->after('bnb'));
        $this->addColumn('altcoin_history', 'ada', $this->float()->after('zec'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('altcoin_history','ada');
        $this->dropColumn('altcoin_history','zec');

        foreach ($this->list as $coin) {
            $altcoin = Altcoin::find()->where(['name' => $coin])->one();
            if ($altcoin) {
                $altcoin->delete();
            }
        }
    }
}
