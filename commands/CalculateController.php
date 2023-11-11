<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\PricesRepository;
use yii\console\widgets\Table;
use yii\helpers\Console;

class CalculateController extends Controller
{
    public function actionIndex($raw_type = "", $month = "", $tonnage = 0)
    {
        $repository = new PricesRepository();

        $getPrice = $repository->getPrice($raw_type, $month, $tonnage);
        
        $missingParams = []; //пустой массив для записи отсутствующего атрибута

        if (empty($raw_type)) {
            $missingParams[] = "Тип";
        }
        if (empty($month)) {
            $missingParams[] = "Месяц";
        }
        if (empty($tonnage)) {
            $missingParams[] = "Тоннаж";
        }

        if (!empty($missingParams)) {
            $errorMessage = Console::ansiFormat("Выполнение команды завершено с ошибкой" . PHP_EOL .
                "Необходимо ввести " . implode(", ", $missingParams), [Console::FG_RED]); //implode разбивает массив на строку
        echo $errorMessage;
        return ExitCode::DATAERR; // dataerr можно вызвать без создания объекта класса 
        }
        
        

        echo "введенные параметры:" . PHP_EOL;
        echo "месяц - " . $month . PHP_EOL;
        echo "тип - " . $raw_type . PHP_EOL;
        echo "тоннаж - " . $tonnage . PHP_EOL;
        echo "результат - " . $getPrice . PHP_EOL;

        
        //таблица:

        $rows = [];
        foreach ($repository->getTonnagesList() as $tonnage) {  //пробегаемся по тоннажам и берем каждый отдельно тоннаж
            $row = [$tonnage]; //создаем массив и в нем строка тоннаж
            foreach ($repository->getMonthsList() as $month) {
                $row[] = $repository->getPrice($raw_type, $month, $tonnage);
            }
            $rows[] = $row;
        }
        $table = new Table();
        
        
        $table 
        ->setHeaders(['тоннаж/месяц', ...array_keys($repository->getMonthsList())])
        ->setRows($rows); // setRows - метод устанавливает строки
        echo $table->run();

        return ExitCode::OK; //уведомление о успешном выполнении кода

       

        // if (!isset(\Yii::$app->params['prices'][$raw_type][$month])) {
        //     $incorrectData[] = "Не найден прайс для значения $month";
        // }

        // if (!isset(\Yii::$app->params['prices'][$raw_type][$month][$tonnage])) {
        //     $incorrectData[] = "Не найден прайс для значения $tonnage";
        // }

        // if (!empty($incorrectData)) {
        //     echo "Выполнение команды завершено с ошибкой" . PHP_EOL .
        //         implode(PHP_EOL , $incorrectData) . PHP_EOL . //разбиваем массив на строку 
        //         "проверьте корректность введенных значений";
        //     return ExitCode::DATAERR;
        // }

        //$priceObj - хранит в себе объект класса Prices и мы обращаемся к св-ву price и указываем ключи массива чтобы получить значение
        
    }
}