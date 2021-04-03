<?php

use yii\db\Migration;

/**
 * Class m210403_162739_drop_altcoin_history
 */
class m210403_162739_drop_altcoin_history extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('altcoin_history');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210403_162739_drop_altcoin_history cannot be reverted.\n";

        return false;
    }
}
