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
        <?= Html::a('Create Carts', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'order_no',
                'seller_id',
                'buyer_id',
                'currency',
                // 'latitude',
                // 'longitude',
                // 'country_id',
                // 'state_id',
                // 'subtotal',
                // 'delivery_fee',
                // 'tax',
                // 'total',
                // 'type',
                // 'status',
                // 'order_placed',
                // 'payment_date',
                // 'created_at',
                // 'updated_at',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
