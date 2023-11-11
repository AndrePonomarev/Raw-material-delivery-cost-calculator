<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%months}}`.
 */
class m230708_055800_create_tonnages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tonnages}}', [
            'id' => $this->primaryKey(11)->unsigned()->notNull(),
            'value' => $this->tinyInteger(10)->unique()->notNull(),
            'create_at' => $this->timestamp()->defaultExpression('NOW()')->notNull(),
            'updated_at' => $this->timestamp()->defaultExpression('NOW()')->notNull()->append('ON UPDATE NOW()'),
        ]);

        $this->batchInsert('{{%tonnages}}', ['value'], [
            ['25'],
            ['50'],
            ['75'],
            ['100'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tonnages}}');
    }
}

