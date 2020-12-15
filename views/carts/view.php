    <?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Carts */

$this->title = $model->order_no;
$this->params['breadcrumbs'][] = ['label' => 'Carts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="carts-view box box-primary">
    <div class="box-header">
       <h4>View Cart</h4>
    </div>
    <div class="box-body table-responsive">
        <div class="row">
            <div class="col-md-6">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'order_no',
                [
                    'label'=>'Seller',

                    'value'=>function($model){
                        return (isset($model->seller->full_name))?$model->seller->full_name:'';
                    }
                ],
                [
                    'label'=>'Buyer',

                    'value'=>function($model){
                        return (isset($model->buyer->full_name))?$model->buyer->full_name:'';
                    }
                ],
                [
                    'label'=>'Country',

                    'value'=>function($model){
                        return (isset($model->country->name))?$model->country->name:'';
                    }
                ],
//                [
//                    'label'=>'State',
//
//                    'value'=>function($model){
//                        return (isset($model->state->name))?$model->state->name:'';
//                    }
//                ],

                'currency',
                'latitude',
                'longitude',
                'subtotal',
                'delivery_fee',
                'tax',
                'total',
                'type',//                            return ($model->document_content!='')?Html::a('Print', \yii\helpers\Url::to([Yii::$app->controller->id.'/printagreement', 'id' => $model->id])):'Not Uploaded';
                [
                    'label'=>'Receipt',

                    'value'=>function($model){
                        return ($model->document!='')?Html::a('Download', Yii::$app->homeUrl.$model->document):'Not Uploaded';

                    },
                    'format' => 'raw',

                ],
                [
                    'label'=>'Address',

                    'value'=>function($model){
                        if($model->type=='Pickup'){
                            return $model->pickupaddress->address;
                        }else if($model->type=='Delivery'){
                            return $model->address;

                        }else{
                            return '';
                        }

                    }
                ],
                [
                    'attribute' => 'status',
                    'label' => 'Status',
                    'value' => function ($model) {
                        if($model->status=='Accepted' && $model->type=='Delivery' && $model->address!=''){
                            $status = 'Delivery In Progress';
                        }else if($model->status=='Accepted' && $model->type=='Pickup' && $model->address_id!=''){
                            $status = 'Ready for Pickup';
                        }else{
                            $status = $model->status;
                        }
                        return Yii::$app->common->getStatus($status);
                    },
                    'format' => 'raw',
                ],
                //'status',
                //'order_placed',
                //'payment_date',
                'created_at:datetime',
               // 'updated_at:datetime',
            ],
        ]) ?>
            </div>
        <div class="col-md-6">
            <h4>Cart Items</h4>
            <?= \yii\grid\GridView::widget([
                'dataProvider' => $dataProvider2,
                //'filterModel' => $searchModel,
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'product_id',

                        'value' => 'product.part_number',

                        //'filter'=>false
                    ],
                    [
                        'label' => 'Brand',

                        'value' => 'product.brand',

                        //'filter'=>false
                    ],
                    [
                        'label' => 'Description',

                        'value' => 'product.description',

                        //'filter'=>false
                    ],
                    [
                        'label'=>'Picture',
                        'value'=> function($model){
                            $image = \app\models\Images::find()->where(['product_id'=>$model->product_id])->one();
                            if(!empty($image)){
                                return Yii::$app->homeUrl.$image->image;
                            }
                        },
                        'format' => ['image',['width'=>'100','height'=>'100']],
                    ],
                    'quantity',
                    'price',
                    'total_price'
                    //'created_at:date',
                    // 'updated_at',


                ],
            ]); ?>

        </div>
        </div>
    </div>
</div>
