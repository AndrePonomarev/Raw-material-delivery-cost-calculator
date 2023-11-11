<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prices}}`.
 */
class m230708_061753_create_prices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('prices', [
            'id' => $this->primaryKey(),
            'tonnage_id' => $this->integer()->unsigned()->notNull(),
            'month_id' => $this->integer()->unsigned()->notNull(),
            'raw_type_id' => $this->integer()->unsigned()->notNull(),
            'price' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey('fk_prices_tonnage_id', 'prices', 'tonnage_id', 'tonnages', 'id', 'NO ACTION', 'CASCADE');
        $this->addForeignKey('fk_prices_month_id', 'prices', 'month_id', 'months', 'id', 'NO ACTION', 'CASCADE');
        $this->addForeignKey('fk_prices_raw_type_id', 'prices', 'raw_type_id', 'raw_types', 'id', 'NO ACTION', 'CASCADE');
        $this->createIndex('idx_prices_tonnage_month_raw', 'prices', ['tonnage_id', 'month_id', 'raw_type_id'], true);
    
        $this->batchInsert('prices',['tonnage_id','month_id','raw_type_id','price'], [
            [1, 1, 1, 125],
            [1, 2, 1, 121],
            [1, 3, 1, 137],
            [1, 4, 1, 126],
            [1, 5, 1, 124],
            [1, 6, 1, 128],
            [2, 1, 1, 145],
            [2, 2, 1, 118],
            [2, 3, 1, 119],
            [2, 4, 1, 121],
            [2, 5, 1, 122],
            [2, 6, 1, 147],
            [3, 1, 1, 136],
            [3, 2, 1, 137],
            [3, 3, 1, 141],
            [3, 4, 1, 137],
            [3, 5, 1, 131],
            [3, 6, 1, 143],
            [4, 1, 1, 138],
            [4, 2, 1, 142],
            [4, 3, 1, 117],
            [4, 4, 1, 124],
            [4, 5, 1, 147],
            [4, 6, 1, 112],
            [1, 1, 2, 121],
            [1, 2, 2, 137],
            [1, 3, 2, 124],
            [1, 4, 2, 137],
            [1, 5, 2, 122],
            [1, 6, 2, 125],
            [2, 1, 2, 118],
            [2, 2, 2, 121],
            [2, 3, 2, 145],
            [2, 4, 2, 147],
            [2, 5, 2, 143],
            [2, 6, 2, 145],
            [3, 1, 2, 137],
            [3, 2, 2, 124],
            [3, 3, 2, 136],
            [3, 4, 2, 143],
            [3, 5, 2, 112],
            [3, 6, 2, 136],
            [4, 1, 2, 142],
            [4, 2, 2, 131],
            [4, 3, 2, 138],
            [4, 4, 2, 112],
            [4, 5, 2, 117],
            [4, 6, 2, 138],
            [1, 1, 3, 137],
            [1, 2, 3, 125],
            [1, 3, 3, 124],
            [1, 4, 3, 122],
            [1, 5, 3, 137],
            [1, 6, 3, 121],
            [2, 1, 3, 147],
            [2, 2, 3, 145],
            [2, 3, 3, 145],
            [2, 4, 3, 143],
            [2, 5, 3, 119],
            [2, 6, 3, 118],
            [3, 1, 3, 112],
            [3, 2, 3, 136],
            [3, 3, 3, 136],
            [3, 4, 3, 112],
            [3, 5, 3, 141],
            [3, 6, 3, 137],
            [4, 1, 3, 122],
            [4, 2, 3, 138],
            [4, 3, 3, 138],
            [4, 4, 3, 117],
            [4, 5, 3, 117],
            [4, 6, 3, 142],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%prices}}');
    }
}