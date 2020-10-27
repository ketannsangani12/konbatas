<?php

namespace app\controllers;

use app\models\MetalsPrices;
use GuzzleHttp\Psr7\UploadedFile;
use Yii;
use app\models\Products;
use app\models\ProductsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
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
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
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
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionImport()
    {
        $model = new Products();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->file = \yii\web\UploadedFile::getInstance($model, 'file');

            if($model->validate()){

                if ( $model->file )
                {
                    $time = time();
                    $model->file->saveAs('uploads/csv/' .$time. '.' . $model->file->extension);
                    $model->file = 'uploads/csv/' .$time. '.' . $model->file->extension;

                    $objPHPExcel = \PHPExcel_IOFactory::load($model->file);
                    $sheetDatas = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    //print_r($sheetData);
                    if (!empty($sheetDatas)){
                      $metalprices = MetalsPrices::find()->orderBy(['id'=>SORT_DESC])->one();
                      $platinum_price = (float)$metalprices->platinum_price;
                      $palladium_price = (float)$metalprices->palladium_price;
                      $rhodium_price = (float)$metalprices->rhodium_price;
                      $usdollar = 14.50;
                      $convertweight = 31.1028;
                      foreach ($sheetDatas as $key=>$sheetData){
                          if($key>1){
                              $productmodel = Products::find()->where(['part_number'=>trim($sheetData['B'])])->one();
                              if(empty($productmodel)){
                                  $productmodel = new Products();

                              }
                              $productmodel->brand = (isset($sheetData['A']))?$sheetData['A']:'';
                              $productmodel->part_number = (isset($sheetData['B']))?$sheetData['B']:'';
                              $productmodel->secondary_part_number = (isset($sheetData['C']))?$sheetData['C']:'';
                              $productmodel->converter_ceramic_weight = (isset($sheetData['D']))?$sheetData['D']:'';
                              $productmodel->type = (isset($sheetData['H']))?$sheetData['H']:'';
                              $weight = (isset($sheetData['D']) && $sheetData['D']!='')?(float)$sheetData['D']:1;
                              $platinum_ppm = (isset($sheetData['E']) && $sheetData['E']!='')?(float)$sheetData['E']:0;
                              $palldium_ppm = (isset($sheetData['F']) && $sheetData['F']!='')?(float)$sheetData['F']:0;
                              $rhodium_ppm = (isset($sheetData['G']) && $sheetData['G']!='')?(float)$sheetData['G']:0;
                              $productmodel->platinum_ppt = $platinum_ppm;
                              $productmodel->palladium_ppt = $palldium_ppm;
                              $productmodel->rhodium_ppt = $rhodium_ppm;
                              $convertervalueusd = $weight*(($platinum_ppm*($platinum_price/$convertweight))+($palldium_ppm*($palladium_price/$convertweight))+($rhodium_ppm*($rhodium_price/$convertweight)))/1000;
                              $productmodel->converter_value = $convertervalueusd;
                              $platinum = (($convertervalueusd-$usdollar)*0.8)+14.50;
                              $gold = (($convertervalueusd-$usdollar)*0.75)+14.50;
                              $green = (($convertervalueusd-$usdollar)*0.7)+14.50;
                              $productmodel->platinum_price = $platinum;
                              $productmodel->gold_price = $gold;
                              $productmodel->green_price = $green;
                              $productmodel->created_at = date('Y-m-d H:i:s');
                              $productmodel->status = 'Active';
                              $productmodel->save(false);



                          }
                      }
                      
                  }


                }


            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'updateproduct';

        if ($model->load(Yii::$app->request->post())) {
            if ($model->load(Yii::$app->request->post()) ) {
                if($model->validate()) {
                    $model->save();
                    return $this->redirect(['index']);


                }else{
                    return $this->render('update', [
                        'model' => $model
                    ]);
                }
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Products model.
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
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}