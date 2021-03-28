<?php

use app\models\Task;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m210315_175736_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'status' => $this->boolean()->defaultValue(false),
            'hours' => $this->float(),
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()',
            'updated_at' => 'TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP()',
        ]);

        $taskList = ['Сесть и подумать', 'Разобраться в деталях', 'Написать в коде'];
        foreach ($taskList as $taskName) {
            $task = new Task();
            $task->name = $taskName;
            $task->hours = 1;
            $task->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task}}');
    }
}
