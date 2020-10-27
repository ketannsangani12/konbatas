<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<div class="col-md-6">
<div class="products-view box box-primary">
    <div class="box-header">

    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                'category_id',
                'brand',
                'part_number',
                'secondary_part_number',
                'description:ntext',
                'platinum_price',
                'gold_price',
                'green_price',
                'converter_value',
                'converter_ceramic_weight',
                'platinum_ppt',
                'palladium_ppt',
                'rhodium_ppt',
                'type',
                'status',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
    </div>
</div>
</div>
</div>