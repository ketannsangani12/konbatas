<?php

namespace app\controllers;

use app\models\MetalsPrices;
use app\models\Products;
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
    public function actionUpdateprices()
    {
        $fromdate = date('Y-m-d 00:00:00');
        $todate = date('Y-m-d H:i:s');

        $model = MetalsPrices::find()->where(['>=','DATE(created_at)', $fromdate])->andWhere(['<=','DATE(created_at)', $todate])->andWhere(['is', 'updated_at', new \yii\db\Expression('null')])->orderBy([
            'id' => SORT_DESC])->one();

                    foreach (Products::find()->each(500) as $product){
                        $id = $product->id;
                        $platinum_price = (float)$model->platinum_price;
                        $palladium_price = (float)$model->palladium_price;
                        $rhodium_price = (float)$model->rhodium_price;
                        $usdollar = 14.50;
                        $convertweight = 31.1028;
                        $platinum_ppm = $product->platinum_ppt;
                        $palladium_ppm = $product->palladium_ppt;
                        $rhodium_ppm = $product->rhodium_ppt;
                        $weight = $product->converter_ceramic_weight;
                        $convertervalueusd = $weight*(($platinum_ppm*($platinum_price/$convertweight))+($palladium_ppm*($palladium_price/$convertweight))+($rhodium_ppm*($rhodium_price/$convertweight)))/1000;
                        $product->converter_value = $convertervalueusd;
                        $platinum = (($convertervalueusd-$usdollar)*0.8)+14.50;
                        $gold = (($convertervalueusd-$usdollar)*0.75)+14.50;
                        $green = (($convertervalueusd-$usdollar)*0.7)+14.50;

                        $product->platinum_price = $platinum;
                        $product->gold_price = $gold;
                        $product->green_price = $green;
                        $product->updated_at = date('Y-m-d H:i:s');
                        $product->save(false);


                    }
                    $model->updated_at = date('Y-m-d H:i:s');
                    $model->save(false);



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
