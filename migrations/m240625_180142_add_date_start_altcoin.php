<?php

use yii\db\Migration;

/**
 * Class m240625_180142_add_date_start_altcoin
 */
class m240625_180142_add_date_start_altcoin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('altcoin', 'date_start', $this->timestamp()->after('full_name'));
        $this->addColumn('altcoin', 'date_start_unix', $this->integer()->after('full_name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('altcoin', 'date_start');
        $this->dropColumn('altcoin', 'date_start_unix');
    }
}
