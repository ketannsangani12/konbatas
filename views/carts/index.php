<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CartsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Carts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carts-index box box-primary">
    <?php Pjax::begin(); ?>
    <div class="box-header with-border">
        <h4>Nearby Carts</h4>
    </div>
    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                'order_no',
                [
                    'attribute' => 'seller_id',

                    'value' => 'seller.full_name',
                    'filter'=>\yii\helpers\ArrayHelper::map(\app\models\Users::find()->where(['role'=>'Seller'])->asArray()->all(), 'id', function($model) {
                        return $model['full_name'];
                    }),
                    'filterInputOptions' => ['class' => 'form-control', 'id' => null, 'prompt' => 'All'],

                    //'filter'=>false
                ],
                //'seller_id',
                'currency',
                // 'latitude',
                // 'longitude',
                [
                    'attribute' => 'country_id',

                    'value' => 'country.name',
                    'filter'=>false,
                    'filterInputOptions' => ['class' => 'form-control', 'id' => null, 'prompt' => 'All'],

                    //'filter'=>false
                ],
                // 'country_id',
                // 'state_id',
                // 'address:ntext',
                // 'subtotal',
                // 'delivery_fee',
                 'tax',
                 'total',
                // 'type',
                [
                    'attribute'=>'status',
                    'format'=>'raw',
                    'value'=> function($model){
                        return Yii::$app->common->getStatus($model->status);
                    },
                    'filter'=>array("Processing"=>"Processing","Accepted"=>"Accepted","Delivered"=>"Delivered"),
                    'filterInputOptions' => ['class' => 'form-control', 'id' => null, 'prompt' => 'All'],

                ],
                //'order_placed:datetime',
                // 'payment_date',
                 'created_at:datetime',
                // 'updated_at',

                ['class' => 'yii\grid\ActionColumn',
                    'template'=>'{view} {update} {deliver}',
                    'visibleButtons' => [
                        'update' => function ($model) {
                            return ($model->status=='Processing');
                        },

                    ],
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
                        'deliver' => function ($url, $model) {

                            return Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', [\yii\helpers\Url::to([Yii::$app->controller->id.'/updatedelivery', 'id' => $model->id])], [

                                'title' => 'Update Delivery',
                                'class' =>'btn btn-sm btn-primary datatable-operation-btn'

                            ]);

                        },


                        'delete' => function ($url, $model) {

                            return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', [\yii\helpers\Url::to([Yii::$app->controller->id.'/delete', 'id' => $model->id])], [

                                'title' => 'Suspend',
                                'class' =>'btn btn-sm btn-danger datatable-operation-btn',
                                'data-confirm' => \Yii::t('yii', 'Are you sure you want to suspend this Seller?'),
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
