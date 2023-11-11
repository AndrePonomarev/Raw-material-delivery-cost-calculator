
<!-- 
<?= yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        [
            'attribute' => 'user_id',
            'value' => function ($data) {
                return Yii::$app->user->can('administrator') ? $data->user->username : 'N/A';
            },
            'visible' => Yii::$app->user->can('administrator'),
        ],
        'tonnage',
        'type_of_material',
        'month',
        'result',
        'created_at:datetime',
        [
            'class' => 'yii\grid\ActionColumn',
            'visible' => Yii::$app->user->can('administrator'),
        ],
        
    ],
]) ?> -->


<?php
use yii\grid\GridView;
use yii\helpers\Html;

// Проверяем, является ли текущий пользователь администратором
$isAdministrator = Yii::$app->user->can('administrator');

// Определяем колонки для отображения в таблице
$columns = [
    'id',
        [
            'attribute' => 'user_id',
            'value' => function ($data) {
                return Yii::$app->user->can('administrator') ? $data->user->username : 'N/A';
            },
            'visible' => Yii::$app->user->can('administrator'),
        ],
    'type_of_material',
    'tonnage',
    'month',
    'result',
    'created_at',
];
$columns[] = [
    'class' => 'yii\grid\ActionColumn',
    'template' => '{view}',
    'buttons' => [
        'view' => function ($url, $model) {
            return Html::a('<span class="glyphicon glyphicon-trash">посмотреть</span>', ['view', 'id' => $model->id], [
                'title' => 'Посмотреть',
            ]);
        },
    ],
];
// Если текущий пользователь - администратор, добавляем колонку для удаления записей
if ($isAdministrator) {
    $columns[] = [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{delete}',
        'buttons' => [
            'delete' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-trash">удалить</span>', ['delete', 'id' => $model->id], [
                    'title' => 'Удалить',
                    'data-confirm' => 'Вы уверены, что хотите удалить эту запись?',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ]);
            },
        ],
    ];
}
echo Html::beginForm(['history'], 'get', ['class' => 'form-inline']);
echo Html::textInput('type_of_material', Yii::$app->request->get('type_of_material'), ['class' => 'form-control', 'placeholder' => 'Тип сырья']);
echo Html::textInput('tonnage', Yii::$app->request->get('tonnage'), ['class' => 'form-control', 'placeholder' => 'Тоннаж']);
echo Html::textInput('month', Yii::$app->request->get('month'), ['class' => 'form-control', 'placeholder' => 'Месяц']);
echo Html::textInput('created_at', Yii::$app->request->get('created_at'), ['class' => 'form-control', 'placeholder' => 'Дата создания']);
echo Html::submitButton('Фильтр', ['class' => 'btn btn-primary']);
echo Html::endForm();

// Выводим таблицу с историей расчетов
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
]);
?>
