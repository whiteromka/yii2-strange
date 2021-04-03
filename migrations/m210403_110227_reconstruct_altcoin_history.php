<?php

use yii\db\Migration;

/**
 * Class m210403_110227_reconstruct_altcoin_history
 */
class m210403_110227_reconstruct_altcoin_history extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('altcoin_history', 'created_at');
        $this->dropColumn('altcoin_history', 'updated_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210403_110227_reconstruct_altcoin_history cannot be reverted.\n";

        return false;
    }
}
