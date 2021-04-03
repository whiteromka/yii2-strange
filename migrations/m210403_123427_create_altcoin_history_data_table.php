<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%altcoin_history_data}}`.
 */
class m210403_123427_create_altcoin_history_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%altcoin_history_data}}', [
            'id' => $this->primaryKey(),
            'altcoin_id' => $this->integer()->notNull()->comment('Ссылка на альткойн'),
            'altcoin_date_id' => $this->integer()->notNull()->comment('Ссылка на дату'),
            'price' => $this->float()
        ]);

        $this->addForeignKey(
            'fk__altcoin_history_data__altcoin_id',
            'altcoin_history_data',
            'altcoin_id',
            'altcoin',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk__altcoin_history_data__altcoin_date_id',
            'altcoin_history_data',
            'altcoin_date_id',
            'altcoin_date',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%altcoin_history_data}}');
    }
}
