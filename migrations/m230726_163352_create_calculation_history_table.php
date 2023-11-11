<?php
use yii\db\Migration;

/**
 * Class m230726_163352_create_calculation_history_table
 */
class m230726_163352_create_calculation_history_table extends Migration
{
    public function up()
    {
        $this->createTable('calculation_history', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type_of_material' => $this->string()->notNull(),
            'tonnage' => $this->decimal(10, 2)->notNull(),
            'month' => $this->string()->notNull(),
            'result' => $this->string()->notNull(),
            'price_table' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Add foreign key constraint to link the calculation_history table with the user table
        $this->addForeignKey('fk_calculation_history_user', 'calculation_history', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        // Drop foreign key constraint first before dropping the calculation_history table
        $this->dropForeignKey('fk_calculation_history_user', 'calculation_history');

        $this->dropTable('calculation_history');
    }
}
