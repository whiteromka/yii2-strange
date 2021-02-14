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

        $this->createTable('altcoin_history', [
            'id' => $this->primaryKey(),
            'altcoin_id' => $this->integer(),

            'rub' => $this->float()->null(),
            'rub_last_changed' => $this->timestamp(),

            'usd' => $this->float()->null(),
            'usd_last_changed' => $this->timestamp(),

            'eur' => $this->float()->null(),
            'eur_last_changed' => $this->timestamp(),

            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()',
            'updated_at' => 'TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP()',
        ]);

        $this->addForeignKey(
            'fk_altcoin_id',
            'altcoin_history',
            'altcoin_id',
            'altcoin',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('idx-altcoin_history-rub_last_changed', 'altcoin_history', 'rub_last_changed' );
        $this->createIndex('idx-altcoin_history-usd_last_changed', 'altcoin_history', 'usd_last_changed' );
        $this->createIndex('idx-altcoin_history-eur_last_changed', 'altcoin_history', 'eur_last_changed' );

        $altcoins = array_combine(Altcoin::getAltcoinListId(), Altcoin::getAltcoinList());
        foreach ($altcoins as $id => $name) {
            $altcoin = new Altcoin();
            $altcoin->id = $id;
            $altcoin->name = $name;
            $altcoin->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('altcoin_history');
        $this->dropTable('altcoin');
    }

}
