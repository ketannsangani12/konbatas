<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cms */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Cms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-view box box-primary">
    <div class="box-header">

    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                'title:ntext',
                [
                    'attribute'=>'photo',
                    'value'=> 'uploads/cms/'.$model->photo,
                    'format' => ['image',['width'=>'100','height'=>'100']],
                ],
                'content:ntext',
                'created_at:datetime',
                //'updated_at:datetime',
            ],
        ]) ?>
    </div>
</div>
