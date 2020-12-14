<?php

namespace app\controllers;

use app\models\Addreses;
use app\models\BankAccounts;
use app\models\CartItems;
use app\models\Carts;
use app\models\Categories;
use app\models\Cms;
use app\models\Countries;
use app\models\EmailTemplates;
use app\models\Faqs;
use app\models\MetalsPrices;
use app\models\Products;
use app\models\States;
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
    private $currency;
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

        if ($action->actionMethod != 'actionLogin' && $action->actionMethod != 'actionRegister' && $action->actionMethod!='actionForgotpassword' && $action->actionMethod!='actionAddrefferal' && $action->actionMethod!='actionVerifyotp' && $action->actionMethod!='actionResendotp' && $action->actionMethod!='actionCountries' && $action->actionMethod!='actionStates') {
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
                        $countrydetail = Countries::findOne($userdata->country);
                        $this->currency = $countrydetail->currency_code;
                       // echo "<pre>";print_r($countrydetail);exit;
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
//               $send = Yii::$app->sms->compose()
//                    ->setFrom('12345')  // if not set in config, or to override
//                    ->setTo('+919925787515')
//                   ->setMessage("Hey sd this is a test!")
//                   ->send();
//                if ( $send === true ) {
//                    echo 'SMS was sent!';
//                } else {
//                    echo 'Error sending SMS!';
//                }
//                exit;
                //var_dump($send);exit;
                $model = new Users();
                $model->scenario = 'register';
                $model->attributes = Yii::$app->request->post();

                if($model->validate()){
                    $model->role = 'Seller';
                    $model->membership_level = 'Green';
                    $model->password = md5(Yii::$app->request->post('password'));
                    $model->verify_token = Yii::$app->getSecurity()->generateRandomString();
                    $model->created_at = date('Y-m-d h:i:s');

                    $save = $model->save(false);
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
                        $countrydetail = ($data['country']!='')?Countries::findOne($data['country']):'';
                        $statedetail = ($data['state']!='')?States::findOne($data['state']):'';
                        $data['currency'] = (!empty($countrydetail))?$countrydetail->currency_code:'';
                        $data['country']  = (!empty($countrydetail))?$countrydetail->name:'';
                        $data['country_id']  = (!empty($countrydetail))?$countrydetail->id:'';
                        $data['tax'] = (!empty($statedetail))?$statedetail->tax:'';
                        $contact_no = $data['contact_no'];
                        if($contact_no!='' && $data['status']==2){
                            $code = rand(100000, 999999);
                            $userdetails = Users::findOne($data['id']);
                            $userdetails->otp = $code;
                            $userdetails->save(false);

                        }
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
    public function actionCountries(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            $countries = Countries::find()->asArray()->all();
            return array('status' => 1, 'data' => $countries);

        }
    }

    public function actionStates(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            if(!empty($_POST) && isset($_POST['country']) && $_POST['country']!=''){
                $countries = States::find()->where(['country_id'=>$_POST['country']])->asArray()->all();
                return array('status' => 1, 'data' => $countries);

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
                    $data = Users::find()->where(['email' => $model->email,'role'=>'Seller'])->one();
                    if(!empty($data)){
                        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

                        $password = substr(str_shuffle($permitted_chars), 0, 10);
                        $data->password = md5($password);
                        $save = $data->save(false);
                        if($save) {
                            $data->password = $password;

                            $emailtemplate = EmailTemplates::findOne(['name'=>'User Forgot Password']);
                            $content = EmailTemplates::getemailtemplate($emailtemplate,$data,'');

                            $send = Yii::$app->mailer->compose()
                                ->setFrom('konbatas@gmail.com')
                                ->setTo($model->email)
                                ->setSubject($emailtemplate->subject)
                                ->setHtmlBody($content)
                                ->send();
                            return array('status' => 1, 'message' => 'New password Sent to your email Successfully');
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
            $countrydetail = ($data['country']!='')?Countries::findOne($data['country']):'';
            $statedetail = ($data['state']!='')?States::findOne($data['state']):'';
            $data['currency'] = (!empty($countrydetail))?$countrydetail->currency_code:'';
            $data['country']  = (!empty($countrydetail))?$countrydetail->name:'';
            $data['country_id']  = (!empty($countrydetail))?$countrydetail->id:'';
            $data['tax'] = (!empty($statedetail))?$statedetail->tax:'';

            $data['bankaccount'] = BankAccounts::find()->where(['user_id'=>$user_id])->asArray()->one();

            if (!empty($data)) {
                return array('status' => 1, 'data' => $data);
            }else{
                return array('status' => 0, 'message' => 'User Id Not Found');
            }

        }
    }

    public function actionUpdatelocation(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            if (!empty($_POST) && isset($_POST['latitude']) && $_POST['latitude']!='' && isset($_POST['longitude']) && $_POST['longitude']!='') {

                $user_id = $this->user_id;
                $model = Users::find()->where(['id' => $user_id])->one();
                $model->latitude = $_POST['latitude'];
                $model->longitude = $_POST['longitude'];
                if($model->save(false)){
                    return array('status' => 1, 'message' => 'You have updated your location successfully.');

                }else{
                    return array('status' => 0, 'message' => 'Something Went wrong.Please try after sometimes');

                }
            }else{
                return array('status' => 0, 'message' => 'Please enter mandatory fields.');

            }
        }
    }

    public function actionUpdateprofile(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            if (!empty($_POST)) {
                $model = Users::find()->where(['id' => $this->user_id])->one();
                $model->scenario = 'updateprofile';
                $model->attributes = Yii::$app->request->post();
                if ($model->validate()) {
                    $model->updated_at = date('Y-m-d H:i:s');
                    $save = $model->save();
                    if ($save){
                        return array('status' => 1, 'message' => 'Profile picture Updated Successfully');
                    }else{
                        return array('status' => 0, 'message' => 'Data Not Updated');
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

    public function actionUploadprofilepicture()
    {

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            $model = Users::findOne(['id'=>$this->user_id]);
            $model->scenario = 'changepicture';
            $model->attributes = Yii::$app->request->post();
            $model->picture = $uploads = UploadedFile::getInstanceByName('picture');
            if($model->validate()){

                $newFileName = \Yii::$app->security
                        ->generateRandomString().'.'.$model->picture->extension;
                $model->image = 'uploads/users/'.$newFileName;
                $model->picture->saveAs('uploads/users/' . $newFileName);
                $model->picture = null;
                if ($model->save(false)){
                    return array('status' => 1, 'message' => 'You have changed your profile picture successfully.');

                }else{
                    return array('status' => 0, 'message' => $model->getErrors());
                }

            }else{
                return array('status' => 0, 'message' => $model->getErrors());
            }

        }


    }
    public function actionDashboard()
    {

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            $user_id = $this->user_id;
            $data['news'] = Cms::find()->orderBy(['id'=>SORT_DESC])->asArray()->all();
            $data['categories'] = Categories::find()->orderBy(['id'=>SORT_DESC])->asArray()->all();
            $data['carts'] = Carts::find()->where(['seller_id'=>$user_id])->orderBy(['id'=>SORT_DESC])->asArray()->all();
            return array('status' => 1, 'data' => $data);

        }


    }


    public function actionFaqs(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            $data = Faqs::find()->asArray()->all();
            return array('status' => 1, 'data' => $data);
        }
    }

    public function actionProducts(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            if (!empty($_POST) && isset($_POST['category_id']) && $_POST['category_id'] != '') {
                    $data = Products::find()->with([
                        'pictures'=>function ($query) {
                            $query->select(['id','product_id','image'])->one();
                        },
                    ])->where(['category_id' => $_POST['category_id']])->asArray()->all();
                    return array('status' => 1, 'data' => $data);
            }else{
                return array('status' => 0, 'message' => 'Please enter mandatory fields.');
            }
        }
    }

    public function actionProductdetails(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            if (!empty($_POST) && isset($_POST['product_id']) && $_POST['product_id'] != '') {
                $data = Products::find()->with('images')->where(['id' => $_POST['product_id']])->asArray()->one();
                return array('status' => 1, 'data' => $data);
            }else{
                return array('status' => 0, 'message' => 'Please enter mandatory fields.');
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
                $user_id = $this->user_id;
                $bankaccountexist = BankAccounts::find()->where(['user_id'=>$user_id])->one();
                if(!empty($bankaccountexist)){
                    $model = $bankaccountexist;

                }else{
                    $model = new BankAccounts();
                    $model->scenario = 'addbankaccount';
                }
                $model->attributes = Yii::$app->request->post();
                if($model->validate()){
                    $model->user_id = $this->user_id;
                    if(isset($model->document) && $model->document!='') {
                        $filename = uniqid();

                        $data = Yii::$app->common->processBase64($model->document);

                        file_put_contents('uploads/users/' . $filename . '.' . $data['type'], $data['data']);
                        $model->document_image = 'uploads/users/' . $filename . '.' . $data['type'];
                    }
                    $model->updated_at = date('Y-m-d H:i:s');

                    $save = $model->save(false);
                    if($save) {
                        return array('status' => 1, 'message' => 'You have updated bank Details Successfully.');
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

    public function actionBankdetails(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            $user_id = $this->user_id;
            $data = BankAccounts::find()->where(['user_id' => $user_id])->asArray()->one();
            if (!empty($data)) {
                return array('status' => 1, 'data' => $data);
            }else{
                return array('status' => 0, 'message' => 'User Id Not Found');
            }

        }
    }
    public function actionMycarts(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            $user_id = $this->user_id;
            $carts = Carts::find()->select('*')->with([
                'cartitems'=>function ($query) {
                    $query->select(['id','cart_id','product_id','quantity','price','total_price','currency']);
                },
                'pickupaddress'=>function ($query) {
                    $query->select(['id','first_name','last_name','address','city','state','mobile_no','address_type']);
                },
                'cartitems.product'=>function ($query) {
                    $query->select(['id','category_id','brand','part_number','secondary_part_number','description']);
                },
                'cartitems.product.images'=>function ($query) {
                    $query->select(['id','product_id','image']);
                },
            ])->where(['seller_id'=>$user_id])->orderBy(['created_at'=>SORT_DESC])->asArray()->all();
            return array('status' => 1, 'data' => $carts);


        }
    }
    public function actionGraph(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            $fromdate = (isset($_POST['fromdate']) && !empty($_POST['fromdate']))?(date('Y-m-d 00:00:00',strtotime($_POST['fromdate']))):'';
            $todate = (isset($_POST['todate']) && !empty($_POST['todate']))?(date('Y-m-d 11:59:59',strtotime($_POST['todate']))):'';

            $query = MetalsPrices::find();
            if($fromdate!='' && $todate!=''){
                // $start = Yii::$app->formatter->asTimestamp($fromdate);
                //$end = Yii::$app->formatter->asTimestamp($todate);
                //$query->andWhere(['between', 'date', $start, $end]);

                $query->andWhere(['>=','DATE(created_at)', $fromdate])->andWhere(['<=','DATE(created_at)', $todate]);
            }
          $prices =   $query->orderBy(['id'=>SORT_ASC])->asArray()->all();
            $prices1 = array();
            if(!empty($prices)){
                foreach ($prices as $key=>$price){
                    $prices[$key]['created_at'] = date('d-M-Y',strtotime($price['created_at']));

                }
            }
            return array('status' => 1, 'data' => $prices);


        }
    }

    public function actionCreatecart(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            if (!empty($_POST) && isset($_POST['items']) && !empty($_POST['items'])) {
                $transaction = Yii::$app->db->beginTransaction();

                try {
                    $model = new Carts();
                    $model->scenario = 'addcart';
                    $model->attributes = Yii::$app->request->post();
                    if ($model->validate()) {
                        $lat = $model->latitude;
                        $long = $model->longitude;
                        $distance = 240;
                        $harvesformula = ($lat!='' && $long!='') ? '( 6371 * acos( cos( radians(' . $lat . ') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians(' . $long . ') ) + sin( radians(' . $lat . ') ) * sin( radians(latitude) ) ) ) as distance': '';
                        $harvesformula1 = ($lat!='' && $long!='') ? '( 6371 * acos( cos( radians(' . $lat . ') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians(' . $long . ') ) + sin( radians(' . $lat . ') ) * sin( radians(latitude) ) ) )' : '';
                        $nearbybuyer = Users::find()->select('id,latitude,longitude,'.$harvesformula)->where(['role'=>'Buyer','status'=>1])->andWhere(['<=', $harvesformula1, $distance])->orderBy(['distance'=>SORT_ASC])->one();
                        if(!empty($nearbybuyer)){
                            $model->buyer_id = $nearbybuyer->id;
                        }
                        $model->seller_id = $this->user_id;
                        $model->created_at = date('Y-m-d H:i:s');
                        $items = json_decode($model->items);
                        $model->items = null;
                        $save = $model->save(false);

                        if ($save) {
                            $cart_id = $model->id;

                          if(!empty($items)){
                              $subtotal = 0;
                              foreach ($items as $value){
                                  $cartitem = new CartItems();
                                  $cartitem->cart_id = $cart_id;
                                  $cartitem->product_id = $value->product_id;
                                  $cartitem->price = $value->price;
                                  $cartitem->quantity = $value->quantity;
                                  $cartitem->total_price = $value->price*$value->quantity;
                                  $subtotal += $cartitem->total_price;
                                  $cartitem->currency = $model->currency;
                                  $cartitem->created_at = date('Y-m-d H:i:s');
                                  $cartitem->save(false);
                              }
                              $model->subtotal=$subtotal;
                              $model->total = $model->subtotal+$model->delivery_fee+$model->tax;
                              $model->status = 'Processing';
                              $model->order_no = Yii::$app->common->generatereferencenumber($cart_id);
                              $model->save(false);
                              $transaction->commit();

                              return array('status' => 1, 'message' => 'You have added Cart Successfully.','cart_no'=>$model->order_no);

                          }else{
                              $transaction->rollBack();

                              return array('status' => 0, 'message' => 'Something Went wrong.Please try after sometimes.');

                          }

                        } else {
                            return array('status' => 0, 'message' => $model->getErrors());
                        }
                    } else {
                        return array('status' => 0, 'message' => $model->getErrors());
                    }
                }catch (Exception $e) {
                    // # if error occurs then rollback all transactions
                    $transaction->rollBack();
                    return array('status' => 0, 'message' => 'Something Went wrong.Please try after sometimes.');

                }
            } else {
                return array('status' => 0, 'message' => 'Please enter mandatory fields.');
            }
        }
    }
    public function actionRetractcart(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            if (!empty($_POST) && isset($_POST['cart_id']) && $_POST['cart_id'] != '') {
                $cartmodel = Carts::findOne($_POST['cart_id']);
                if(empty($cartmodel)){
                    return array('status' => 0, 'message' => 'No cart detail found.');

                }
                $cartmodel->status = 'Cancelled';
                $cartmodel->updated_at = date('Y-m-d H:i:s');
                if($cartmodel->save(false)){
                    return array('status' => 1, 'message' => 'You have retracted Cart Successfully.');

                }else{
                    return array('status' => 0, 'message' => 'Something Went wrong.Please try after sometimes.');

                }

            }else{
                return array('status' => 0, 'message' => 'Please enter mandatory fields.');
            }
        }
    }
    public function actionPlaceorder(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            if (!empty($_POST) && isset($_POST['cart_id']) && $_POST['cart_id'] != '') {
                $cartmodel = Carts::find()->where(['status'=>'Accepted','id'=>$_POST['cart_id']])->one();
                if(empty($cartmodel)){
                    return array('status' => 0, 'message' => 'No cart detail found.');

                }
                $cartmodel->scenario = 'placeorder';
                $cartmodel->attributes = Yii::$app->request->post();
                if($cartmodel->validate()) {
                    if($cartmodel->type=='Pickup'){
                        $cartmodel->address_id = $cartmodel->address;
                        $cartmodel->address = null;
                    }

                    if ($cartmodel->save(false)) {
                        return array('status' => 1, 'message' => 'You have updated Cart Successfully.');

                    } else {
                        return array('status' => 0, 'message' => 'Something Went wrong.Please try after sometimes.');

                    }
                }else{
                    return array('status' => 0, 'message' => $cartmodel->getErrors());

                }

            }else{
                return array('status' => 0, 'message' => 'Please enter mandatory fields.');
            }
        }
    }

    public function actionAddaddress(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            if (!empty($_POST) ) {
                $model = new Addreses();
                $model->scenario = 'add';
                $model->attributes = Yii::$app->request->post();
                if ($model->validate()) {
                    $model->user_id = $this->user_id;
                    $model->created_at = date('Y-m-d H:i:s');
                    if($model->save(false)){
                        return array('status' => 1, 'message' => 'You have added Address Successfully.');

                    }else{
                        return array('status' => 0, 'message' => 'Something Went wrong.Please try after sometimes.');

                    }

                }else{
                    return array('status' => 0, 'message' => $model->getErrors());

                }

                }else{
                return array('status' => 0, 'message' => 'Please enter mandatory fields.');
            }
        }
    }
    public function actionAddresses(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return array('status' => 0, 'message' => 'Bad request.');
        } else {
            $addresses = Addreses::find()->where(['user_id'=>$this->user_id])->asArray()->all();
            return array('status' => 1, 'data' => $addresses);

        }
    }

   public function actionGetconversionrate(){
       $currency = $this->currency;
       if($currency!=''){
           $currencyrate = Yii::$app->common->getconversionrate($currency);
           if($currencyrate!=''){
               return array('status' => 1, 'data' => $currencyrate);

           }else{
               return array('status' => 0, 'message' => 'Something Went wrong.Please try after sometimes');

           }

       }else{
           return array('status' => 0, 'message' => 'Something Went wrong.Please try after sometimes');

       }

   }

}