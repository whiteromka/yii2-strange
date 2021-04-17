<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%altcoin_watcher}}`.
 */
class m210411_082410_create_altcoin_watcher_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%altcoin_watcher}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(), // на будущее, сейчас не актуально
            'altcoin_id' => $this->integer(),
            'wish_price' => $this->float()->comment('Ставка при которой оповестить пользователя'),
            'price_at_conclusion' => $this->float()->comment('Цена при которой пользователь сделал ставку'),
            'expectation' => $this->tinyInteger()->comment('Ожидание - рост ил падение курса')
        ]);

        $this->addForeignKey(
            'fk__altcoin_watcher__altcoin_id',
            'altcoin_watcher',
            'altcoin_id',
            'altcoin',
            'id',
            'cascade',
            'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%altcoin_watcher}}');
    }
}
