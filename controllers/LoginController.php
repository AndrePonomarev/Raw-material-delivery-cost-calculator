<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\User;

class LoginController extends Controller
{ 
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->set('user_id', Yii::$app->user->id);
            Yii::$app->session->set('username', Yii::$app->user->identity->username);
            Yii::$app->session->setFlash('success', 'Здравствуйте, ' . Yii::$app->user->identity->username . ', вы авторизовались в системе расчета стоимости доставки. Теперь все ваши расчеты будут сохранены для последующего просмотра в журнале расчетов.');

            return $this->goBack();
        }

        $model->password_hash = '';
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
