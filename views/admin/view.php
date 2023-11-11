<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Изменить', ['update', 'id' => $user->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Удалить', ['delete', 'id' => $user->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Вы уверены, что хотите удалить этого пользователя?',
            'method' => 'post',
        ],
    ]) ?>
</p>

<?= DetailView::widget([
    'model' => $user,
    'attributes' => [
        'id',
        'username',
        'email',
        'role',
        'created_at:datetime',
        'updated_at:datetime',
    ],
]) ?>
