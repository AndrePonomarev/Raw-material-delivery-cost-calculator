<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['administrator'], // Разрешено только для пользователей с ролью 'administrator'
                    ],
                ],
            ],
        ];
    }

    public function actionUsers()
    {
        // Check if the current user has the role "administrator"
        if (Yii::$app->user->can('administrator')) {
            $dataProvider = new ActiveDataProvider([
                'query' => User::find(),
            ]);

            return $this->render('users', [
                'dataProvider' => $dataProvider,
            ]);
        } else {
            // If the user doesn't have access, redirect them to another page or display an error message
            return $this->redirect(['/site/error']);
        }
    }
    public function actionDelete($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден.');
        }

        // Удаление пользователя
        $user->delete();

        // Перенаправляем пользователя на страницу списка пользователей после удаления
        return $this->redirect(['users']);
    }


    /**
     * Найти модель пользователя по идентификатору.
     * @param integer $id идентификатор пользователя
     * @return User найденная модель пользователя
     * @throws NotFoundHttpException если пользователь не найден
     */


public function actionUpdate($id)
{
    $user = $this->findUserModel($id);

    if (!Yii::$app->user->can('administrator')) {
        throw new ForbiddenHttpException('У вас нет прав для редактирования пользователя.');
    }

    $auth = Yii::$app->authManager;
    $roles = $auth->getRoles();

    if ($user->load(Yii::$app->request->post())) {
        $user->username = Yii::$app->request->post()['User']['username'];
        $user->email = Yii::$app->request->post()['User']['email'];

        if (isset(Yii::$app->request->post()['User']['role']) && isset($roles[Yii::$app->request->post()['User']['role']])) {
            // Снимаем текущую роль
            $currentRole = $auth->getRole($user->role->name);
            $auth->revoke($currentRole, $user->id);
            
            // Назначаем новую роль
            $role = $auth->getRole(Yii::$app->request->post()['User']['role']);
            $auth->assign($role, $user->id);

        }

        if ($user->save()) {
            Yii::$app->session->setFlash('success', 'Данные пользователя успешно обновлены.');
            return $this->redirect(['update', 'id' => $user->id]);
        }
    }

    return $this->render('update', [
        'user' => $user,
        'roles' => $roles
    ]);
}


    protected function findUserModel($id)
    {
        $user = User::findOne($id);
        if ($user === null) {
            throw new NotFoundHttpException('Пользователь не найден.');
        }
        return $user;
    }
}

