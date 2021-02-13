<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%estate}}`.
 */
class m210112_181535_create_estate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%estate}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'type' => $this->tinyInteger()->notNull(),
            'name' => $this->string()->notNull(),
            'cost' => $this->integer()->notNull(),
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()',
            'updated_at' => 'TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP()',
        ]);

        $this->addForeignKey(
            'fk_estate__user_id',
            'estate',
            'user_id',
            'user',
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
        $this->dropForeignKey('fk_estate__user_id', 'estate');
        $this->dropTable('{{%estate}}');
    }
}