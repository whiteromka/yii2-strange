<?php

use yii\db\Migration;

/**
 * Class m220308_140307_recreate_shop_migra
 */
class m220308_140307_recreate_shop_migra extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('cart', 'total_count', $this->integer()->defaultValue(0));
        $this->alterColumn('cart', 'total_price', $this->integer()->defaultValue(0));
        $this->alterColumn('cart', 'total_discount', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220308_140307_recreate_shop_migra cannot be reverted.\n";

        return false;
    }
}
