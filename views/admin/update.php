<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Изменить пользователя: ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->username, 'url' => ['update', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($user, 'username')->textInput() ?>

    <?= $form->field($user, 'email')->textInput() ?>

    <?= $form->field($user, 'role')->dropDownList([
        'user' => 'Пользователь',
        'administrator' => 'Администратор',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
