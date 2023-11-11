<?php

use yii\grid\GridView;
use yii\helpers\Html;

// ...
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'username',
        'email',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-pencil">изменить</span>', ['update', 'id' => $model->id], [
                        'title' => Yii::t('yii', 'Update'),
                    ]);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-trash">удалить</span>', ['delete', 'id' => $model->id], [
                        'title' => Yii::t('yii', 'Delete'),
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                    ]);
                },
            ],
        ],
    ],
]); ?>
