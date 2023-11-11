<?php

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\web\JqueryAsset;

AppAsset::register($this);

$this->registerJsFile('@web/js/main.js', ['depends' => [JqueryAsset::class]]);

?>
<div class="row">
    <h2>
        Калькулятор стоимости доставки сырья
    </h2>
</div>

<div class="row">

    <div class="col-md-4">

        <?php $form = ActiveForm::begin([
              'id' => 'calculation-form', // Уникальный идентификатор формы для Ajax-валидации
              'enableAjaxValidation' => true, // Включаем Ajax-валидацию
]); ?>
        <?=
            $form->field($model, 'month')
                ->dropDownList(
                    $repository->getMonthsList(),
                    [ 'prompt' => 'Выберите параметр' ]
                );
        ?>

        <?=
            $form->field($model, 'raw_type')
                ->dropDownList(
                    $repository->getRawTypesList(),
                    [ 'prompt' => 'Выберите параметр' ]
                );
        ?>

        <?=
            $form->field($model, 'tonnage')
                ->dropDownList(
                    $repository->getTonnagesList(),
                    [ 'prompt' => 'Выберите параметр' ]
                );
        ?>

        <?= Html::submitButton($content = "Рассчитать", ["class" => "btn btn-success"]) ?>

        <?php \yii\widgets\ActiveForm::end() ?>

    </div>

</div>

<div id="result-container"></div>