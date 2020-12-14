<?php

namespace app\controllers;

use app\models\CartItems;
use app\models\Devices;
use app\models\Notifications;
use app\models\Users;
use paragraph1\phpFCM\Recipient\Device;
use Yii;
use app\models\Carts;
use app\models\CartsSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CartsController implements the CRUD actions for Carts model.
 */
class CartsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','deleteimage','upload','add','update'],
                'rules' => [
                    [
                        'actions' => ['index','deleteimage','upload','create','add','update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Carts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CartsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Carts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $query2 = CartItems::find()->where(['cart_id'=>$id]);
        $dataProvider2 = new ActiveDataProvider([
            'query' => $query2,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider2' => $dataProvider2,

        ]);
    }

    /**
     * Creates a new Carts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Carts();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Carts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'acceptorreject';
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()) {
                $model->updated_at = date('Y-m-d H:i:s');
                if($model->save(false)) {
                    if(!empty($model->buyer_id)){
                        $buyerdetails = Users::findOne($model->buyer_id);
                        $full_name = $buyerdetails->full_name;
                        $buyer_id = $model->buyer_id;
                    }else{
                        $full_name = 'Admin';
                        $buyer_id = 1;
                    }
                    $subject = "Cart ".$model->status." - ".$model->order_no;
                    $textmessage = "Your cart has ".$model->status." by ".$full_name;
                    $notificationmodel = new Notifications();
                    $notificationmodel->sender_id = $buyer_id;
                    $notificationmodel->receiver_id = $model->seller_id;
                    $notificationmodel->transaction_id = $id;
                    $notificationmodel->subject = $subject;
                    $notificationmodel->text = $textmessage;
                    $notificationmodel->created_at = date('Y-m-d H:i:s');
                    $notificationmodel->save(false);
                    if($subject!='' && $textmessage!='' ) {
                        $devices = Devices::find()->where(['user_id' => $model->seller_id])->all();
                        if (!empty($devices)) {
                            $note = Yii::$app->fcm1->createNotification($subject, $textmessage);
                            $note->setIcon('fcm_push_icon')->setSound('default')->setClickAction('FCM_PLUGIN_ACTIVITY')
                                ->setColor('#ffffff');

                            $message = Yii::$app->fcm1->createMessage();

                            foreach ($devices as $device) {
                                $message->addRecipient(new Device($device->device_token));
                            }

                            $message->setNotification($note)
                                ->setData([
                                    'title' => $subject,
                                    'body' => $textmessage
                                ]);

                            $response = Yii::$app->fcm1->send($message);
                        }
                    }

                    return $this->redirect(['index']);
                }


            }else{
                return $this->render('update', [
                    'model' => $model,
                    'delivery'=>false
                ]);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
                'delivery'=>false
            ]);
        }
    }

    public function actionUpdatedelivery($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'deliverorder';
        if ($model->load(Yii::$app->request->post())) {
            $model->receipt = \yii\web\UploadedFile::getInstance($model, 'receipt');

            if($model->validate()) {
                $newFileName = \Yii::$app->security
                        ->generateRandomString().'.'.$model->receipt->extension;
                $model->document = 'uploads/receipts/'.$newFileName;

                $model->updated_at = date('Y-m-d H:i:s');
                if($model->save(false)) {
                    $model->receipt->saveAs('uploads/receipts/' . $newFileName);
                    if(!empty($model->buyer_id)){
                        $buyerdetails = Users::findOne($model->buyer_id);
                        $full_name = $buyerdetails->full_name;
                        $buyer_id = $model->buyer_id;
                    }else{
                        $full_name = 'Admin';
                        $buyer_id = null;
                    }
                    $subject = "Cart Delivered - ".$model->order_no;
                    $textmessage = "Your cart has Delivered to ".$full_name;
                    $notificationmodel = new Notifications();
                    $notificationmodel->sender_id = $buyer_id;
                    $notificationmodel->receiver_id = $model->seller_id;
                    $notificationmodel->transaction_id = $id;
                    $notificationmodel->subject = $subject;
                    $notificationmodel->text = $textmessage;
                    $notificationmodel->created_at = date('Y-m-d H:i:s');
                    $notificationmodel->save(false);
                    if($subject!='' && $textmessage!='' ) {
                        $devices = Devices::find()->where(['user_id' => $model->seller_id])->all();
                        if (!empty($devices)) {
                            $note = Yii::$app->fcm1->createNotification($subject, $textmessage);
                            $note->setIcon('fcm_push_icon')->setSound('default')->setClickAction('FCM_PLUGIN_ACTIVITY')
                                ->setColor('#ffffff');

                            $message = Yii::$app->fcm1->createMessage();

                            foreach ($devices as $device) {
                                $message->addRecipient(new Device($device->device_token));
                            }

                            $message->setNotification($note)
                                ->setData([
                                    'title' => $subject,
                                    'body' => $textmessage
                                ]);

                            $response = Yii::$app->fcm1->send($message);
                        }
                    }
                    return $this->redirect(['index']);
                }


            }else{
                return $this->render('update', [
                    'model' => $model,
                    'delivery'=>true
                ]);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
                'delivery'=>true
            ]);
        }
    }
    /**
     * Deletes an existing Carts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Carts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Carts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Carts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
