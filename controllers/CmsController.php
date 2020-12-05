<?php

namespace app\controllers;

use Yii;
use app\models\Cms;
use app\models\CmsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CmsController implements the CRUD actions for Cms model.
 */
class CmsController extends Controller
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
     * Lists all Cms models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CmsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cms model.
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
     * Creates a new Cms model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cms();
        $model->scenario = 'addcms';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->load(Yii::$app->request->post()) ) {
                $model->picture = \yii\web\UploadedFile::getInstance($model, 'picture');

                if($model->validate()) {
                    $newFileName = \Yii::$app->security
                            ->generateRandomString().'.'.$model->picture->extension;
                    $model->photo = 'uploads/cms/'.$newFileName;
                    $model->created_at = date('Y-m-d H:i:s');
                    if($model->save(false)){
                        $model->picture->saveAs('uploads/cms/' . $newFileName);
                        return $this->redirect(['index']);

                    }


                }else{
                    return $this->render('create', [
                        'model' => $model
                    ]);
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Cms model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'updatecms';
        if ($model->load(Yii::$app->request->post())) {
            if(!empty($_FILES['Cms']['name']['picture'])){
                $model->picture = \yii\web\UploadedFile::getInstance($model, 'picture');
                $newFileName = \Yii::$app->security
                        ->generateRandomString().'.'.$model->picture->extension;
                $model->photo = 'uploads/cms/'.$newFileName;
               }
                if($model->validate()) {
                    if(isset($newFileName)){
                        $model->picture->saveAs('uploads/photo/' . $newFileName);
                    }
                    $model->save();
                    return $this->redirect(['index']);


                }else{
                    return $this->render('update', [
                        'model' => $model
                    ]);
                }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Cms model.
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
     * Finds the Cms model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cms the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cms::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
