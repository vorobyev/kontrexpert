<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Organization;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::info('Пользователь '.$model->name.' вошел',__METHOD__);
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::info('Пользователь '.Yii::$app->user->identity->name.' вышел',__METHOD__);
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionClients()
    {
        if (!isset(Yii::$app->request->get()['new'])&&(!isset(Yii::$app->request->get()['kontrid']))) {
            $provider = new ActiveDataProvider([
                'query' => Organization::find(), //где файл является видеоблоком
                'pagination' => [
                'pageSize' => 20,
                 ],
            ]);    
            return $this->render('clientsall', [
                'provider'=>$provider
                   ]);            
        } else {
            if (isset(Yii::$app->request->get()['kontrid'])){
                $model = Organization::findOne((int)Yii::$app->request->get()['kontrid']);
            } else {
                $model = new Organization();
            }
            if ($model == null) {
                 return $this->render('error', [
                            'message' => 'Контрагент с id='.Yii::$app->request->get()['kontrid'].' отсутствует в базе данных.',
                            'name'=>'Ошибка базы данных'
                        ]); 
            }
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(Url::to(['site/clients','kontrid'=>$model->id]));            
            } else {
                return $this->render('clients', [
                            'model' => $model,
                        ]); 
            }
        }
    }
}
