<?php

use yii\db\Migration;

/**
 * Class m210515_164135_products_and_cards
 */
class m210515_164135_products_and_cards extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'pid' => $this->integer(),
            'name' => $this->string(100),
            'slug' => $this->string(100),
            'description' => $this->string(),
            'status' => $this->tinyInteger()->defaultValue(1),
            'sort' => $this->integer()->defaultValue(1),
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()',
            'updated_at' => 'TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP()',
        ]);

        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'name' => $this->string(100),
            'slug' => $this->string(100),
            'description' => $this->string(),
            'price' => $this->float(),
            'old_price' => $this->float(),
            'is_new' => $this->boolean()->defaultValue(false),
            'status' => $this->tinyInteger()->defaultValue(1),
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()',
            'updated_at' => 'TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP()',
        ]);

        $this->addForeignKey(
            'fk__category_id__product',
            'product',
            'category_id',
            'category',
            'id',
            'cascade',
            'cascade'
        );

        $this->createTable('card', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'total_count' => $this->integer(),
            'total_price' => $this->integer(),
            'total_discount' => $this->integer(),
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()',
            'updated_at' => 'TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP()',
        ]);

        $this->addForeignKey(
            'fk__user_id__card',
            'card',
            'user_id',
            'user',
            'id',
            'cascade',
            'cascade'
        );

        $this->createTable('card_item', [
            'id' => $this->primaryKey(),
            'card_id' => $this->integer(),
            'product_id' => $this->integer(),
            'count' => $this->integer(),
            'price' => $this->integer(),
            'discount' => $this->integer(),
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()',
            'updated_at' => 'TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP()',
        ]);

        $this->addForeignKey(
            'fk__card_id__card_item',
            'card_item',
            'card_id',
            'card',
            'id',
            'cascade',
            'cascade'
        );

        $this->addForeignKey(
            'fk__product_id__card_item',
            'card_item',
            'product_id',
            'product',
            'id',
            'cascade',
            'cascade'
        );

        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'total_count' => $this->integer(),
            'total_price' => $this->integer(),
            'total_discount' => $this->integer(),
            'status' => $this->integer()->defaultValue(1),
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()',
            'updated_at' => 'TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP()',
        ]);

        $this->createTable('order_item', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'product_id' => $this->integer(),
            'count' => $this->integer(),
            'price' => $this->integer(),
            'discount' => $this->integer(),
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()',
            'updated_at' => 'TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP()',
        ]);

        $this->addForeignKey(
            'fk__order_id__order_item',
            'order_item',
            'order_id',
            'order',
            'id',
            'cascade',
            'cascade'
        );

        $this->addForeignKey(
            'fk__product_id__order_item',
            'order_item',
            'product_id',
            'product',
            'id',
            'cascade',
            'cascade'
        );

        $this->createTable('stock', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'count' => $this->integer(),
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()',
            'updated_at' => 'TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP()',
        ]);

        $this->addForeignKey(
            'fk__product_id__stock',
            'stock',
            'product_id',
            'product',
            'id',
            'cascade',
            'cascade'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('stock');
        $this->dropTable('order_item');
        $this->dropTable('order');
        $this->dropTable('card_item');
        $this->dropTable('card');
        $this->dropTable('product');
        $this->dropTable('category');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210515_164135_products_and_cards cannot be reverted.\n";

        return false;
    }
    */
}
