<?php

namespace app\controllers;

use app\models\BankAccounts;
use Da\QrCode\QrCode;
use sizeg\jwt\JwtHttpBearerAuth;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\db\Transaction;
use yii\debug\models\search\User;
use yii\filters\auth\HttpBearerAuth;
use yii\swiftmailer\Mailer;
use yii\web\NotFoundHttpException;
use Codeception\Events;
use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use app\models\Users;
use yii\filters\auth\HttpBasicAuth;
use yii\web\UploadedFile;
use yii\helpers\Url;
//use paragraph1\phpFCM\Recipient\Device;
class ApiusersController extends ActiveController
{
    public $modelClass = 'app\models\Users';
    private $language = 1;
    public $baseurl = null;
    private $user_id;
    public static function allowedDomains()
    {
        return [
            '*',                        // star allows all domains
            // 'http://localhost:3000',
            // 'http://test2.example.com',
        ];
    }
    public function init()
    {

        if($_SERVER['HTTP_HOST'] != 'rumah.test') {
            $this->baseurl = Url::base('https');
        }else{
            $this->baseurl = Url::base(true);
        }

        parent::init(); // TODO: Change the autogenerated stub
    }

    public  function actionPrint($data){
        echo "<pre>";print_r($data);exit;
    }
    /**
     * {@inheritdoc}
     */
//    public function behaviors()
//    {
//
//        return [
//            'contentNegotiator' => [
//                'class' => ContentNegotiator::className(),
//                'formats' => [
//                    'application/json' => Response::FORMAT_JSON,
//                ]
//            ],
//
//        ];
//    }

    public function behaviors()
    {

        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ]
            ],

        ];
    }
    public function beforeAction($action)
    {
        header('Access-Control-Allow-Origin: *');

        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

        header("Access-Control-Allow-Headers: X-Requested-With,token,user");
        parent::beforeAction($action);

        if ($action->actionMethod != 'actionLogin' && $action->actionMethod != 'actionRegister' && $action->actionMethod!='actionForgotpassword' && $action->actionMethod!='actionAddrefferal' && $action->actionMethod!='actionVerifyotp' && $action->actionMethod!='actionResendotp') {
            $headers = Yii::$app->request->headers;
            if(!empty($headers) && isset($headers['token']) && $headers['token']!=''){
                try{
                    $token = Yii::$app->jwt->getParser()->parse((string) $headers['token']);
                    $data = Yii::$app->jwt->getValidationData(); // It will use the current time to validate (iat, nbf and exp)
                    $data->setIssuer(\Yii::$app->params[ 'hostInfo' ]);
                    $data->setAudience(\Yii::$app->params[ 'hostInfo' ]);
                    $data->setId('4f1g23a12aa');
                    // $data->setCurrentTime(time() + 61);
                    if($token->validate($data)){
                        $userdata = $token->getClaim('uid');
                        $this->user_id = $userdata->id;
                        return true;


                    }else{
                        echo json_encode(array('status' => 0, 'message' => 'Authentication Failed.'));exit;

                    }
                }catch (Exception $e) {
                    echo json_encode(array('status' => 0, 'message' => 'Authentication Failed.'));exit;

                }

                //var_dump($token->validate($data));exit;

                //return true;
            }else{

                echo json_encode(array('status' => 0, 'message' => 'Authentication Failed.'));exit;
            }
            //exit;
        }
        return true;


    }



    //Login users

    public function actionRegister()
    {

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            if (!empty($_POST)) {
                $model = new Users();
                $model->scenario = 'register';
                $model->attributes = Yii::$app->request->post();

                if($model->validate()){
                    $model->role = 'Seller';
                    $model->password = md5(Yii::$app->request->post('password'));
                    $model->verify_token = Yii::$app->getSecurity()->generateRandomString();
                    $model->created_at = date('Y-m-d h:i:s');

                    $save = $model->save();
                    if($save) {
                        return array('status' => 1, 'message' => 'You have Registered  Successfully.We have sent you OTP on your mobile number,Please verify it.','user_id'=>$model->id);
                    }else{
                        return array('status' => 0, 'message' => 'You have Not Registered  Successfully');
                    }
                }else{
                    return array('status' => 0, 'message' => $model->getErrors());
                }

            } else {
                return array('status' => 0, 'message' => 'Please enter mandatory fields.');
            }
        }
    }

    public function actionLogin(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            if (!empty($_POST)) {
                $model = new Users();
                $model->scenario = 'loginapp';
                $model->attributes = Yii::$app->request->post();
                if ($model->validate()) {
                    $data = Users::find()->where(['email' => $model->email ,'password' => md5($model->password),'role'=>'Seller'])->asArray()->one();
                    if(!empty($data)){
                        $token = (string)Users::generateToken($data);
                        return array('status' => 1, 'message' => 'You have Logged  Successfully','data'=>$data,'token'=>$token);
                    }else{
                        return array('status' => 0, 'message' => 'Incorrect Email or password ');
                    }
                } else {
                    return array('status' => 0, 'message' => $model->getErrors());
                }
            }else{
                return array('status' => 0, 'message' => 'Please enter mandatory fields.');
            }
        }
    }

    public function actionForgotpassword(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            if (!empty($_POST)) {
                $model = new Users();
                $model->scenario = 'forgotpassword';
                $model->attributes = Yii::$app->request->post();
                if ($model->validate()) {
                    $data = Users::find()->where(['email' => $model->email])->one();
                    if(!empty($data)){
                        $data->password = md5('12345');
                        $save = $data->save();
                        if($save) {
                            Yii::$app->mailer->compose()
                                ->setFrom('tlssocietyapps@gmail.com')
                                ->setTo($data->email)
                                ->setSubject('test')
                                ->setTextBody('hellow world')
                                ->setHtmlBody('<b>Your Password is</b>')
                                ->setHtmlBody($data->password)
                                ->send();
                            return array('status' => 1, 'message' => 'Email Sent Successfully');
                        }else{
                            return array('status' => 0, 'message' => 'Password Does Not Changed');
                        }
                    }else{
                        return array('status' => 0, 'message' => 'Incorrect Email');
                    }
                }
                else {
                    return array('status' => 0, 'message' => $model->getErrors());
                }
            }else{
                return array('status' => 0, 'message' => 'Please enter mandatory fields.');
            }
        }
    }

    public function actionChangepassword(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            if (!empty($_POST)) {
                $model = new Users();
                $model->scenario = 'changepassword';
                $model->attributes = Yii::$app->request->post();
                if ($model->validate()) {
                    $userid = $this->user_id;
                    $data = Users::find()->where(['password' =>  md5($model->oldpassword),'id'=>$userid])->one();
                    if (!empty($data)){
                        $data->password =  md5(Yii::$app->request->post('newpassword'));
                        $save = $data->save();
                        if ($save) {
                            return array('status' => 1, 'message' => 'Password Change Successfully');
                        }else{
                            return array('status' => 0, 'message' => 'Password Does Not Changed');
                        }
                    }else{
                        return array('status' => 0, 'message' => 'Old Is Incorrect Password');
                    }
                }else{
                    return array('status' => 0, 'message' => $model->getErrors());
                }
            }else{
                return array('status' => 0, 'message' => 'Please enter mandatory fields.');
            }
        }
    }

    public function actionMyprofile(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            $user_id = $this->user_id;
            $data = Users::find()->where(['id' => $user_id])->asArray()->one();
            if (!empty($data)) {
                return array('status' => 1, 'data' => $data);
            }else{
                return array('status' => 0, 'message' => 'User Id Not Found');
            }

        }
    }

//    BANK ACCOUNT API

    public function actionAddbankaccount(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            if (!empty($_POST)) {
                $model = new BankAccounts();
                $model->scenario = 'addbankaccount';
                $model->attributes = Yii::$app->request->post();

                if($model->validate()){
                    $model->user_id = $this->user_id;
                    $model->document_image = 'test.jpeg';
                    $model->created_at = date('Y-m-d H:i:s');
                    $model->updated_at = date('Y-m-d H:i:s');

                    $save = $model->save();
                    if($save) {
                        return array('status' => 1, 'message' => 'You have add bank Details Successfully.');
                    }else{
                        return array('status' => 0, 'message' => 'somthing Went wrong');
                    }
                }else{
                    return array('status' => 0, 'message' => $model->getErrors());
                }

            } else {
                return array('status' => 0, 'message' => 'Please enter mandatory fields.');
            }
        }
    }

}
