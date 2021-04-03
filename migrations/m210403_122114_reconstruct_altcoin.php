<?php

use app\models\Altcoin;
use yii\db\Migration;

/**
 * Class m210403_122114_reconstruct_altcoin
 */
class m210403_122114_reconstruct_altcoin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('altcoin', 'sort', $this->integer()->after('full_name')->defaultValue(2));
        /** @var Altcoin  $alt */
        $alt = Altcoin::find()->where(['name' => 'BTC'])->one();
        if ($alt) {
            $alt->sort = 1;
            $alt->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210403_122114_reconstruct_altcoin cannot be reverted.\n";

        return false;
    }
}
