<?php

namespace app\controllers;

use app\models\CalculatorForm;
use yii\rest\Controller;
use app\models\PricesRepository;
use Yii;
use Yii\web\Response;

class ApiController extends Controller
{
    public function actionCalculatePrice()
    {
        $model = new CalculatorForm();
        $repository = new PricesRepository(); 
        Yii::$app->response->format = Response::FORMAT_JSON; // Установлен формат JSON
        if ($model->load(Yii::$app->request->get(),'') && $model->validate()) {   // Модель загружает get запрос
            return [
            'price' => $repository->getPrice($model->raw_type, $model->month, $model->tonnage),
            'price_list' => [$model->raw_type => $repository->getMonthsByRawTypeForApi($model->raw_type)]
          ];
        }
        return ['error' => 'ошибка'];
    } 
}