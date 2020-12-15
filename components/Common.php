<?php
namespace app\components;


use app\models\Users;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\debug\models\search\User;

class Common extends Component
{

    public function getconversionrate($currency){

        $endpoint = 'latest';
        $access_key = 'ee41793cb65c196994f3f77de23cb04d';

// Initialize CURL:
        $ch = curl_init('https://data.fixer.io/api/'.$endpoint.'?access_key='.$access_key.'&base=USD');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

// Decode JSON response:
        $exchangeRates = json_decode($json, true);

// Access the exchange rate values, e.g. GBP:
        if(!empty($exchangeRates)){
           if(isset($exchangeRates['rates'][$currency])){
               return $exchangeRates['rates'][$currency];
           }else{
               return '';
           }

        }else{
            return '';
        }
        //echo "<pre>";print_r($exchangeRates);exit;

    }
    public function getStatus($status)
    {
        switch ($status){
            case "New";
                return "<span class='btn btn-warning btn-xs'>New</span>";
                break;
            case "Processing";
                return "<span class='btn btn-warning btn-xs'>Processing</span>";
                break;
            case "Accepted";
                return "<span class='btn bg-green btn-xs'>Accepted</span>";
                break;
            case "Delivered";
                return "<span class='btn bg-green btn-xs'>Delivered</span>";
                break;
            case "Completed";
                return "<span class='btn bg-green btn-xs'>Completed</span>";
                break;
            case "Agreement Processed";
                return "<span class='btn bg-orange btn-xs'>Agreement Processed</span>";
                break;
            case "Refund Requested";
                return "<span class='btn bg-orange btn-xs'>Refund Requested</span>";
                break;
            case "Confirmed";
                return "<span class='btn bg-orange btn-xs'>Confirmed</span>";
                break;
            case "Work In Progress";
                return "<span class='btn bg-orange btn-xs'>Work In Progress</span>";
                break;
            case "Picked Up";
                return "<span class='btn bg-orange btn-xs'>Picked Up</span>";
                break;
            case "In Progress";
                return "<span class='btn bg-orange btn-xs'>In Progress</span>";
                break;
            case "Declined";
                return "<span class='btn btn-danger btn-xs'>Declined</span>";
                break;
            case "Rejected";
                return "<span class='btn btn-danger btn-xs'>Rejected</span>";
                break;
            case "Cancelled";
                return "<span class='btn btn-danger btn-xs'>Cancelled</span>";
                break;
            case "Closed";
                return "<span class='btn btn-danger btn-xs'>Closed</span>";
                break;
            case "Unpaid";
                return "<span class='btn btn-danger btn-xs'>Unpaid</span>";
                break;
            case "Paid";
                return "<span class='btn bg-green btn-xs'>Paid</span>";
                break;
            case "Delivery In Progress";
                return "<span class='btn bg-blue btn-xs'>Delivery In Progress</span>";
                break;
            case "Ready for Pickup";
                return "<span class='btn bg-blue btn-xs'>Ready for Pickup</span>";
                break;
            case "Rented";
                return "<span class='btn bg-green btn-xs'>Rented</span>";
                break;
            case "Terminated";
                return "<span class='btn btn-danger btn-xs'>Suspended</span>";
                break;
            case "Incompleted";
                return "<span class='btn btn-danger btn-xs'>Incompleted</span>";
                break;
        }
    }
    public function processBase64($data){
        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                throw new \Exception('invalid image type');
            }

            $data = base64_decode($data);

            if ($data === false) {
                throw new \Exception('base64_decode failed');
            }

            return ['data'=>$data, 'type'=>$type];
        } else {
            throw new \Exception('did not match data URI with image data');
        }
    }

    public function generatereferencenumber($id)
    {
        if ($id && $id != null && $id != '' && is_numeric($id)) {
            $encrypted = (((((($id * 2) + 383) * 8) + 1048) - 157) - 28) * 3;
            return $encrypted;
        } else {
            return null;
        }

    }
    public function calculatesst($amount)
    {
        $total_fees = number_format($amount * 6 / 100, 2, '.', '');
        return $total_fees;


    }
    public function getsystemaccount()
    {
        $systemaccount = Users::find()->where(['role'=>'Systemaccount'])->one();
        return $systemaccount;


    }
    public function validatesecondarypassword($user_id,$password){
        $userdetails = Users::findOne($user_id);

        return ($userdetails->secondary_password==md5($password))?true:false;


    }

}