<?php

use yii\db\Migration;

/**
 * Class m210501_175456_reconstruct_user
 */
class m210501_175456_reconstruct_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'email', $this->string()->unique()->after('birthday'));
        $this->addColumn('user', 'password_hash', $this->string()->after('birthday'));
        $this->addColumn('user', 'access_token', $this->string()->after('birthday'));
        $this->addColumn('user', 'auth_key', $this->string()->after('birthday'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'email');
        $this->dropColumn('user', 'password_hash');
        $this->dropColumn('user', 'access_token');
        $this->dropColumn('user', 'auth_key');
    }
}
