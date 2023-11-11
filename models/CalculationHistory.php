<?php

namespace app\models;

use yii\db\ActiveRecord;

class CalculationHistory extends ActiveRecord
{
    public static function tableName()
    {
        return 'calculation_history';
    }

    public function getUser()
    {
        // Определение отношения "пользователь" для связи CalculationHistory с моделью User
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
