<?php

namespace app\controllers;

use Yii;
use app\models\MetalsPrices;
use app\models\MetalsPricesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MetalspricesController implements the CRUD actions for MetalsPrices model.
 */
class MetalspricesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }





    /**
     * Creates a new MetalsPrices model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = MetalsPrices::find()->orderBy([
            'id' => SORT_DESC])->one();

        if ($model->load(Yii::$app->request->post())) {
                if($model->validate()) {

                        $newmodel = new MetalsPrices();
                        $newmodel->palladium_price = $model->palladium_price;
                        $newmodel->platinum_price = $model->platinum_price;
                        $newmodel->rhodium_price = $model->rhodium_price;
                        $newmodel->created_at = date('Y-m-d H:i:s');
                        if($newmodel->save()) {
                            return $this->redirect(['create']);
                        }


                }else{
                    return $this->render('create', [
                        'model' => $model
                    ]);
                }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MetalsPrices model.
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
     * Deletes an existing MetalsPrices model.
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
     * Finds the MetalsPrices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MetalsPrices the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MetalsPrices::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}