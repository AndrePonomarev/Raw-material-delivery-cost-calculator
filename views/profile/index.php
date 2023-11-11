<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= DetailView::widget([
    'model' => $user,
    'attributes' => [
        'username',
        'email',
        [
            'attribute' => 'role',
            'value' => function ($user) {
                $auth = Yii::$app->authManager;
                $role = $auth->getRole($user->role->name);
                return $role->name;
            },
        ],
    ],
]) ?>
