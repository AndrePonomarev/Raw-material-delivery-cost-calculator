<?php

namespace app\models;

class CalculatorForm extends \yii\base\Model
{
    public $month;
    public $raw_type;
    public $tonnage;

    public function attributeLabels()
    {
        return [
            'month' => 'Месяц текущего года',
            'raw_type' => 'Тип сырья',
            'tonnage' => 'Тоннаж',
        ];
    }


    public function rules()
    {
        return [
            [['month','raw_type','tonnage'], 'required', 'message' => 'Необходимо заполнить поле']
        ];
    }
}