<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">

    <?if (Yii::$app->user->isGuest) {
    $userData = Yii::$app->session->get('username');
    // Доступ к данным пользователя из сессии
    // Другие данные пользователя из сессии
}?>

    <?php
   $user = Yii::$app->user->identity;

   NavBar::begin([
       'options' => [
           'class' => 'navbar navbar-expand-lg navbar-light bg-light',
       ],
   ]);
   
   // Пункты меню для неавторизованных пользователей
   if (Yii::$app->user->isGuest) {
       echo Nav::widget([
           'options' => ['class' => 'navbar-nav ml-auto'],
           'items' => [
               ['label' => 'Расчет стоимости', 'url' => ['/']], // переход в корень сайта
           ],
       ]);
       echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto mb-2 mb-lg-0'],
        'items' => [
            ['label' => 'Войти в систему', 'url' => ['/login']],
            ['label' => 'Регистрация', 'url' => ['/signup']],
        ],
    ]);

   } else { // Пункты меню для авторизованных пользователей

    if (Yii::$app->user->can('administrator')) {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ml-auto'],
            'items' => [
                ['label' => 'Расчет стоимости', 'url' => ['/']], // переход в корень сайта
            ],
        ]);
        
        echo Nav::widget([
           'options' => ['class' => 'navbar-nav ms-auto mb-2 mb-lg-0'],
           'items' => [
               [
                   'label' => $user->username, // Показываем имя пользователя в выпадающем списке
                   'items' => [
                       ['label' => 'Профиль', 'url' => ['/profile']],
                       ['label' => 'История расчетов', 'url' => ['/history']],
                       ['label' => 'Пользователи', 'url' => ['/admin/users']],
                       ['label' => 'Выход', 'url' => ['/logout'], 'linkOptions' => ['data-method' => 'post']],
                   ],
               ],
           ],
       ]);
        
    }else{
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ml-auto'],
            'items' => [
                ['label' => 'Расчет стоимости', 'url' => ['/']], // переход в корень сайта
            ],
        ]);

        echo Nav::widget([
           'options' => ['class' => 'navbar-nav ms-auto mb-2 mb-lg-0'],
           'items' => [
               [
                   'label' => $user->username, // Показываем имя пользователя в выпадающем списке
                   'items' => [
                       ['label' => 'Профиль', 'url' => ['/profile']],
                       ['label' => 'История расчетов', 'url' => ['/history']],
                       ['label' => 'Выход', 'url' => ['/logout'], 'linkOptions' => ['data-method' => 'post']],
                   ],
               ],
           ],
       ]);
    }
    
   }
   
   NavBar::end();
   ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; ЭФКО Стартер <?= date('Y') ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


