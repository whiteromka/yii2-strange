<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%passport}}`.
 */
class m201124_165606_create_passport_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%passport}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment("Связь с таблицей user"),
            'number' => $this->integer(),
            'code' => $this->integer(),
            'country' => $this->string(),
            'city' => $this->string(),
            'address' => $this->string(),
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()',
            'updated_at' => 'TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP()'
        ]);

        $this->addForeignKey(
            'fk_passport__user_id',
            'passport',
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
        $this->dropForeignKey('fk_passport__user_id', 'passport');
        $this->dropTable('{{%passport}}');
    }
}
