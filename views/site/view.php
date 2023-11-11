<h1>История расчета №<?= $history->id ?></h1>

<p>Имя пользователя: <?= Yii::$app->user->can('administrator') ? $history->user->username : 'N/A' ?></p>
<p>Параметры расчета:</p>
<pre><?= $history->tonnage ?></pre>
<pre><?= $history->month ?></pre>
<pre><?= $history->type_of_material ?></pre>
<p>Результат расчета: <?= $history->result ?></p>
<p>Таблица прайса:</p>
<pre><?= $history->price_table = json_decode($history->price_table) ?></pre>
<p>Дата создания расчета: <?= Yii::$app->formatter->asDatetime($history->created_at) ?></p>
<a href='/history'> Назад </a>

