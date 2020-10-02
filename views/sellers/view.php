<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-md-6">

<div class="booking-requests-view box box-primary">
    <div class="box-header">

    </div>
    <div class="box-body table-responsive">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'username',
            //'role',
            'full_name',
            //'last_name',
            //'wallet_balance',
            'membership_level',
            [
                'label'=>'Country',

                'value'=>function($model){
                    return (isset($model->countryname->name))?$model->countryname->name:'';
                }
            ],
            'contact_no',
            'email:email',
            'business_type',
            'average_converters',
            'bank_account_name',
            'bank_account_no',
            'bank_name',
            //'image',
            //'created_at',
            //'updated_at',
        ],
    ]) ?>

        </div>
    </div>
        </div>
    </div>