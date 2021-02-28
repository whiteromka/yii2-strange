<?php

use app\models\Altcoin;
use yii\db\Migration;

/**
 * Class m210214_110843_crypto
 */
class m210214_110843_crypto extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('altcoin', [
            'id' => $this->primaryKey(),
            'name'=> $this->string()->unique(),
            'full_name' => $this->string()->unique(),
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()',
            'updated_at' => 'TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP()',
        ]);

        $this->createTable('altcoin_date', [
            'id' => $this->primaryKey(),
            'date' => $this->timestamp(),
            'unix_date' => $this->integer()->unsigned(),
        ]);

        $this->createTable('altcoin_history', [
            'id' => $this->primaryKey(),
            'altcoin_date_id' => $this->integer(),
            'btc' => $this->float()->null(),
            'eth' => $this->float()->null(),
            'ltc' => $this->float()->null(),
            'xrp' => $this->float()->null(),
            'atom' => $this->float()->null(),
            'xmr' => $this->float()->null(),
            'bnb' => $this->float()->null(),
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()',
            'updated_at' => 'TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP()',
        ]);

        $this->addForeignKey(
            'fk_altcoin_history__altcoin_date_id',
            'altcoin_history',
            'altcoin_date_id',
            'altcoin_date',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $altcoins = array_combine(Altcoin::getAltcoinListId(), Altcoin::getAltcoinList());
        foreach ($altcoins as $id => $name) {
            $altcoin = new Altcoin();
            $altcoin->id = $id;
            $altcoin->name = $name;
            $altcoin->save(false);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('altcoin_history');
        $this->dropTable('altcoin_date');
        $this->dropTable('altcoin');
    }
}
