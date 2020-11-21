<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m201121_074429_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name'=> $this->string(),
            'surname' => 'string null',
            'gender' => $this->tinyInteger(),
            'birthday' => $this->date(),
            'birthday_date_time' => $this->dateTime(),
            'unix_birthday' => $this->integer(),
            'created_at' => 'datetime not null default current_timestamp()',
            'updated_at' => 'datetime null default null on update current_timestamp()',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
