<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="registration-form">
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>