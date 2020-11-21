<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%t}}`.
 */
class m201121_070037_create_t_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%t}}', [
            'id' => $this->primaryKey(),
            'date' => 'date not null default current_timestamp()',
            'datetime' => 'datetime not null default current_timestamp()',
            'timestamp' => 'timestamp not null default current_timestamp()'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%t}}');
    }
}
