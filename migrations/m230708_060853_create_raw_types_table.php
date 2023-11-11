<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%months}}`.
 */
class m230708_060853_create_raw_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%raw_types}}', [
            'id' => $this->primaryKey(11)->unsigned()->notNull(),
            'name' => $this->string(10)->unique()->notNull(),
            'create_at' => $this->timestamp()->defaultExpression('NOW()')->notNull(),
            'updated_at' => $this->timestamp()->defaultExpression('NOW()')->notNull()->append('ON UPDATE NOW()'),
        ]);

        $this->batchInsert('{{%raw_types}}', ['name'], [
            ['Шрот'],
            ['Жмых'],
            ['Соя'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%raw_types}}');
    }
}

