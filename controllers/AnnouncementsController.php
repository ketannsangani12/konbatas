<?php

namespace app\controllers;

use app\models\Devices;
use paragraph1\phpFCM\Recipient\Device;
use Yii;
use app\models\Announcements;
use app\models\AnnouncementsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AnnouncementsController implements the CRUD actions for Announcements model.
 */
class AnnouncementsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','delete','update','view'],
                'rules' => [
                    [
                        'actions' => ['index','delete','create','update','view'],
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
     * Lists all Announcements models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AnnouncementsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Announcements model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Announcements model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Announcements();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {

                $model->created_at = date('Y-m-d h:i:s');
                $model->datetime = date('Y-m-d H:i:s', strtotime($model->datetime));
                if ($model->save()) {
//                    if($model->type=='Customer'){
//                        $devices = Devices::find()->where(['!=', 'user_id', ''])->all();
//                        //print_r($devices);exit;
//                        if(!empty($devices)) {
//                            $note = Yii::$app->fcm1->createNotification($model->subject, $model->description);
//                            $note->setIcon('fcm_push_icon')->setSound('default')->setClickAction('FCM_PLUGIN_ACTIVITY')
//                                ->setColor('#ffffff');
//
//                            $message = Yii::$app->fcm1->createMessage()
//                                ->setData([
//                                'notification_type' => 'announcement',
//                                'title' => $model->subject,
//                                'body' => $model->description
//                            ]);
//
//                            foreach ($devices as $device) {
//                                $message->addRecipient(new Device($device->device_token));
//                            }
//
//                            $message->setNotification($note);
//
//                            $response = Yii::$app->fcm1->send($message);
//                        }
//                    }
//                    if($model->type=='Merchant'){
//                        $devices = Devices::find()->where(['!=', 'merchant_id', ''])->all();
//                        //print_r($devices);exit;
//                        if(!empty($devices)) {
//                            $note = Yii::$app->fcm2->createNotification($model->subject, $model->description);
//                            $note->setIcon('fcm_push_icon')->setSound('default')->setClickAction('FCM_PLUGIN_ACTIVITY')
//                                ->setColor('#ffffff');
//
//                            $message = Yii::$app->fcm2->createMessage();
//
//                            foreach ($devices as $device) {
//                                $message->addRecipient(new Device($device->device_token));
//                            }
//
//                            $message->setNotification($note)
//                                ->setData([
//                                    'notification_type' => 'announcement',
//                                    'title' => $model->subject,
//                                    'body' => $model->description
//                                ]);
//
//                            $response = Yii::$app->fcm2->send($message);
//                        }
//                    }
//                }

                    return $this->redirect(['index']);
                } else {
                    return $this->render('create', [
                        'model' => $model
                    ]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }else{
            return $this->render('create', [
                'model' => $model,
            ]);

        }
    }

    /**
     * Updates an existing Announcements model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Announcements model.
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
     * Finds the Announcements model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Announcements the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Announcements::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
