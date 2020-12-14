<?php

namespace app\controllers;

use app\models\Users;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','logout'],
                'rules' => [
                    [
                        'actions' => ['logout','index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Users();
        $model->scenario = 'login';
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if(Yii::$app->user->identity->role=='Buyer'){
             $userscheckdocument = Users::findOne(Yii::$app->user->id);
             if($userscheckdocument->document==''){
                 return $this->redirect(['uploaddocument']);

             }else{
                 return $this->goBack();

             }
            }else{
                return $this->goBack();

            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    public function actionChangepassword()
    {
        $model = new Users();
        $model->scenario = 'changepassword';
        // print_r($model);exit;
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()) {
                $userdetails = Users::findOne(['id'=>Yii::$app->user->id]);
                // var_dump($_POST);exit;
                //print_r(Yii::$app->request->post('password'));exit;
                $userdetails->password = md5($_POST['Users']['password']);
                if($userdetails->save()){
                    Yii::$app->session->setFlash('success', "You have changed password successfully.");

                    return $this->redirect(['changepassword']);
                }
                //  Yii::$app->session->setFlash('contactFormSubmitted');
            }else{
                return $this->render('changepassword', [
                    'model' => $model,
                ]);
            }

            // return $this->refresh();
        }
        return $this->render('changepassword', [
            'model' => $model,
        ]);
    }
    public function actionUploaddocument()
    {
        $model = Users::findOne(Yii::$app->user->id);
        $model->scenario = 'uploaddocument';
        // print_r($model);exit;
        if ($model->load(Yii::$app->request->post())) {
            $model->documentid = \yii\web\UploadedFile::getInstance($model, 'documentid');

            if($model->validate()) {
                if($model->save()){
                    $time = time();
                    $model->documentid->saveAs('uploads/users/' .$time. '.' . $model->documentid->extension);
                    $model->document = 'uploads/users/' .$time. '.' . $model->documentid->extension;
                    $model->save(false);
                    Yii::$app->session->setFlash('success', "You have updated profile successfully.");

                    return $this->redirect(['index']);
                }
                //  Yii::$app->session->setFlash('contactFormSubmitted');
            }else{
                return $this->render('uploaddocument', [
                    'model' => $model,
                ]);
            }

            // return $this->refresh();
        }
        return $this->render('uploaddocument', [
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

    public function actionCallback(){
        print_r($_REQUEST);exit;
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
