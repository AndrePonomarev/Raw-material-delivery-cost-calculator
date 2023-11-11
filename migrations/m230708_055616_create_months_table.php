<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%months}}`.
 */
class m230708_055616_create_months_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%months}}', [
            'id' => $this->primaryKey(11)->unsigned()->notNull(),
            'name' => $this->string(10)->unique()->notNull(),
            'create_at' => $this->timestamp()->defaultExpression('NOW()')->notNull(),
            'updated_at' => $this->timestamp()->defaultExpression('NOW()')->notNull()->append('ON UPDATE NOW()'),
        ]);

        $this->batchInsert('{{%months}}', ['name'], [
            ['Январь'],
            ['Февраль'],
            ['Август'],
            ['Сентябрь'],
            ['Октябрь'],
            ['Ноябрь'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%months}}');
    }
}

