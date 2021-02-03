<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index box box-primary">
    <?php Pjax::begin(); ?>
    <div class="box-header with-border">
        <?= Html::a('Import Products', ['import'], ['class' => 'btn btn-primary btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                //'category_id',
                'brand',
                'part_number',
                'secondary_part_number',
                // 'description:ntext',
                 'platinum_price',
                 'gold_price',
                 'green_price',
                 'converter_value',
                 'converter_ceramic_weight',
                // 'platinum_ppt',
                // 'palladium_ppt',
                // 'rhodium_ppt',
                // 'type',
                // 'status',
                // 'created_at',
                // 'updated_at',

                ['class' => 'yii\grid\ActionColumn',
                    'template'=>'{view} {update} {gallery} {delete}',

                    'buttons'=>[

                        'view' => function ($url, $model) {

                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', [\yii\helpers\Url::to([Yii::$app->controller->id.'/view', 'id' => $model->id])], [

                                'title' => 'View',
                                'class'=>'btn btn-sm bg-purple datatable-operation-btn'

                            ]);

                        },
                        'update' => function ($url, $model) {

                            return Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', [\yii\helpers\Url::to([Yii::$app->controller->id.'/update', 'id' => $model->id])], [

                                'title' => 'Update',
                                'class' =>'btn btn-sm btn-warning datatable-operation-btn'

                            ]);

                        },

                        'gallery' => function ($url, $model) {

                            return Html::a('<i class="fa fa-picture-o" aria-hidden="true"></i>', ['images/create','id'=>$model->id], [

                                'title' => 'Images',
                                'class'=>'btn btn-sm bg-blue datatable-operation-btn'

                            ]);

                        },
                        'delete' => function ($url, $model) {

                            return Html::a('<i class="fa fa-eye-slash" aria-hidden="true"></i>', [\yii\helpers\Url::to([Yii::$app->controller->id.'/delete', 'id' => $model->id])], [

                                'title' => 'Delete',
                                'class' =>'btn btn-sm btn-danger datatable-operation-btn',
                                'data-confirm' => \Yii::t('yii', 'Are you sure you want to hide this item?'),
                                'data-method'  => 'post',

                            ]);

                        },



                    ],
                ],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
