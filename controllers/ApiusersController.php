<?php

namespace app\controllers;

use app\models\AgentRatings;
use app\models\BankAccounts;
use app\models\BookingRequests;
use app\models\Chats;
use app\models\EmailTemplates;
use app\models\FavouriteProperties;
use app\models\GoldTransactions;
use app\models\Ilifestyle;
use app\models\Images;
use app\models\Istories;
use app\models\PromoCodes;
use app\models\Properties;
use app\models\PropertyRatings;
use app\models\PropertyViews;
use app\models\ServicerequestImages;
use app\models\ServiceRequests;
use app\models\TodoDocuments;
use app\models\TodoItems;
use app\models\TodoList;
use app\models\Topups;
use app\models\Transactions;
use app\models\TransactionsItems;
use app\models\UsersDocuments;
use app\models\VendorRatings;
use app\models\Withdrawals;
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
                $refferal_code = (isset($_POST['referral_code']))?$_POST['referral_code']:'';

                $model = new Users();
                $model->scenario = 'register';
                $model->attributes = Yii::$app->request->post();

                if($model->validate()){
                    $model->role = 'User';
                    $model->password = md5(Yii::$app->request->post('password'));
                    $model->verify_token = Yii::$app->getSecurity()->generateRandomString();
                    $model->created_at = date('Y-m-d h:i:s');

                    $save = $model->save();

                    if($save){

                        if(!empty($refferal_code)){
                            $referall_id = Users::getUserIdFromReferralCode($refferal_code);
                            if($referall_id!=null && $model->id!=$referall_id){
                                $referral_user = Users::findOne($referall_id);
                                if(!empty($referral_user)){
                                    $model->save(false);

                                    return array('status' => 1, 'message' => 'You have Registered  Successfully.We have sent you OTP on your mobile number,Please verify it.','user_id'=>$model->id);


                                }else{
                                    return array('status' => 0, 'message' => 'Please enter Valid Referral Code.');
                                }
                                //return array('status' => 0, 'message' => 'Please enter Valid Referral Code.');
                            }else{
                                return array('status' => 0, 'message' => 'Please enter Valid Referral Code.');

                            }
                        }else{
                            $model->save(false);

                            return array('status' => 1, 'message' => 'You have Registered  Successfully.We have sent you OTP on your mobile number,Please verify it.','user_id'=>$model->id);

                        }

                    }else{
                        return array('status' => 0, 'message' => 'Something went wrong.Please try after sometimes.');
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
