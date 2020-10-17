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
            'company_name',
            //'wallet_balance',
            //'membership_level',

           // 'contact_no',
            'email:email',
            'latitude',
            'longitude',
            'address',
            'offering_pickup',
            'bank_name',
            'bank_account_name',
            'bank_account_no',
            'crated_at',
        ],
    ]) ?>

        </div>
    </div>
        </div>
    </div>