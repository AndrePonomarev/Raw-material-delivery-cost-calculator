<?php

namespace app\models;

use yii\db\ActiveRecord;
use \yii\db\Query;
use yii\helpers\ArrayHelper;

class PricesRepository extends ActiveRecord
{
    
    public function getMonthsList()
    {
        $query = (new Query())->select(['name'])->orderBy('id')->from('months')->all();
        return ArrayHelper::map($query, 'name', 'name');
    }

    public function getRawTypesList()
    {
        $query = (new Query())->select(['name'])->orderBy('id')->from('raw_types')->all();
        return ArrayHelper::map($query, 'name', 'name');
    }

    public function getTonnagesList()
    {
        $query = (new Query())->select(['value'])->orderBy('id')->from('tonnages')->all();
        return ArrayHelper::map($query, 'value', 'value');
    }
    
    public function getPrice($raw_type, $month, $tonnage)
    { 
        return (new Query())
        ->select('price')
        ->from('prices')
        ->innerJoin('tonnages', 'prices.tonnage_id = tonnages.id') //применяем связь внешних ключей
        ->innerJoin('months', 'prices.month_id = months.id')
        ->innerJoin('raw_types', 'prices.raw_type_id = raw_types.id')
        ->where('raw_types.name=:raw_type AND tonnages.value=:tonnage AND months.name=:month', 
            ['raw_type' => $raw_type, 'tonnage'=>$tonnage, 'month'=>$month])
        ->scalar(); // единичное значение
    }

    public function getMonthsByRawTypeForApi($raw_type)
    {
        $queryIdRawType = new Query();
        $rawTypeId = $queryIdRawType->select(['id'])->from(['raw_types'])->where('name=:name',[':name' => $raw_type])->all();
        $query = new Query();
        $q = $query->select(['price','value','name'])
        ->from(['prices'])
        ->InnerJoin('tonnages', 'tonnages.id = prices.tonnage_id')
        ->InnerJoin('months', 'months.id = prices.month_id')
        ->where('raw_type_id = :r',[':r'=>$rawTypeId[0]['id']])
        ->all();

        $result = [];
        foreach ($q as $key => $value) {
            $result[$value['name']][$value['value']] = (int)$value['price'];
        }
        return $result;
    }


    public function createTable($raw_type) {
    
     $result = '<table class="table table-bordered table-striped"><thead><th>Месяц/Тоннаж</th>';
                  
        foreach ($this->getTonnagesList() as $tonnage):
         $result .= "<th>" . $tonnage  . "</th>";
        endforeach;
    
        $result .= '</thead><tbody>';
        
        foreach ($this->getMonthsList() as $month):
         $result .= '<tr><td>' . $month . '</td>';
                            
            foreach ($this->getTonnagesList() as $tonnage):
                $result .= '<td>' . $this->getPrice($raw_type, $month, $tonnage) . '</td>';
            endforeach;
            
            $result .= '</tr>';
        endforeach;
        
        $result .= '</tbody></table>';
                
    
        return $result;
    }

    public function createTableHeader($raw_type, $model, $repository)
    {
        $result = '<div class="row"><div class="col-md-4 mt-2 mb-2"><div class="card"><div class="card-body">Введенные данные:';

        foreach($model->getAttributes() as $key => $attribute):
            $result .= '<div>' . $model->getAttributeLabel($key) . "<strong>" . ': ' . $attribute . "</strong></div>";
        endforeach;

        $result .= '<div>Итог, руб.: ' . $repository->getPrice($model->raw_type, $model->month, $model->tonnage);
        $result .= "</div></div></div></div></div>";

        return $result;
    }
}