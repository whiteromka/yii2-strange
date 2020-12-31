<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%city}}`.
 */
class m201230_161653_create_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%city}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'district' => $this->string(),
            'population' => $this->integer(),
            'subject' => $this->string(),
            'lat' => $this->float(),
            'lon' => $this->float(),
        ]);

        $this->createIndex('index_city_name', 'city', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('index_city_name', 'city');
        $this->dropTable('{{%city}}');
    }
}
