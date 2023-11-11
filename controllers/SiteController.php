<?php

namespace app\controllers;

use app\models\CalculatorForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\PricesRepository;
use app\models\User;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\CalculationHistory;
use yii\data\ActiveDataProvider;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::class,
    //             'only' => ['logout'],
    //             'rules' => [
    //                 [
    //                     'actions' => ['logout'],
    //                     'allow' => true,
    //                     'roles' => ['@'],
    //                 ],
    //             ],
    //         ],
    //         'verbs' => [
    //             'class' => VerbFilter::class,
    //             'actions' => [
    //                 'logout' => ['post'],
    //             ],
    //         ],
    //     ];
    // }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    // public function actionIndex()
    // {
    //     return $this->render('index');
    // }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */

    public function actionIndex()
    {
        $filePath = Yii::getAlias('../runtime/queue.job');

        $model = new CalculatorForm();

        $repository = new PricesRepository(); // добавлен на уроке 5

        // if ($model->load(Yii::$app->request->post())) {

        //     if (file_exists($filePath)) {
        //         unlink($filePath);
        //     }

        //     foreach ($model->getAttributes() as $key => $value) {
        //         file_put_contents($filePath, "$key => $value \n", FILE_APPEND);
        //     }
        // }
        
        
        return $this->render('index', ['model' => $model,'repository'=>$repository]);
    }

    public function actionHistory()
    {
        $query = CalculationHistory::find()->where(['user_id' => Yii::$app->user->id]);

        // Применяем фильтры из GET-параметров
        $query->andFilterWhere(['like', 'type_of_material', Yii::$app->request->get('type_of_material')]);
        $query->andFilterWhere(['like', 'tonnage', Yii::$app->request->get('tonnage')]);
        $query->andFilterWhere(['like', 'month', Yii::$app->request->get('month')]);
        $query->andFilterWhere(['like', 'created_at', Yii::$app->request->get('created_at')]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        return $this->render('history', ['dataProvider' => $dataProvider]);
    }

    public function actionView($id) // просмотр истории записей 
    {
        $history = CalculationHistory::findOne($id);

        // Проверка, что запись принадлежит текущему пользователю (или пользователь администратор)
        if ($history && ($history->user_id == Yii::$app->user->id || Yii::$app->user->can('administrator'))) {
            return $this->render('view', [
                'history' => $history,
            ]);
        }

        throw new \yii\web\ForbiddenHttpException('Доступ запрещен.');
    }

    public function actionDelete($id) //удаление записей истории просмотра
    {
        $history = CalculationHistory::findOne($id);

        // Проверка, что запись принадлежит текущему пользователю (или пользователь администратор)
        if ($history && ($history->user_id == Yii::$app->user->id || Yii::$app->user->can('administrator'))) {
            $history->delete();
            Yii::$app->session->setFlash('success', 'Расчет успешно удален из истории.');
        } else {
            throw new \yii\web\ForbiddenHttpException('Доступ запрещен.');
        }

        return $this->redirect(['history']);
    }


    public function actionCalculate() {
        $model = new CalculatorForm();
        $repository = new PricesRepository(); // добавлен на уроке 5
    
        if ($model->load(Yii::$app->request->post()) && (Yii::$app->user->can('user') || Yii::$app->user->can('administrator'))) {
            $this->createCalculationHistory($model, $repository);
        }
    
        $result = $repository->createTableHeader($model->raw_type, $model, $repository) . $repository->createTable($model->raw_type);
    
        return $result;
    }
    
    protected function createCalculationHistory($model, $repository) {
        $calculationHistory = new CalculationHistory();
        $calculationHistory->user_id = Yii::$app->user->id; // ID текущего пользователя
        $calculationHistory->type_of_material = $model->raw_type;
        $calculationHistory->tonnage = $model->tonnage;
        $calculationHistory->month = $model->month;
        $calculationHistory->result = $repository->getPrice($model->raw_type, $model->month, $model->tonnage);
        $calculationHistory->price_table = json_encode($repository->createTable($model->raw_type)); // Преобразование в JSON
        $calculationHistory->created_at = date('Y-m-d H:i:s');
        $calculationHistory->save();
    }
    
    
     
}

