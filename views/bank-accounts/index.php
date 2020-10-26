<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BankAccountsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bank Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-accounts-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Create Bank Accounts', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

//                'id',
//                'user_id',
                'account_number',
                'account_name',
                'bank_name',
                 'swift_code',
                [
                    'label' => 'document_image',
                    'format' => ['image',['width'=>'120']],
                    'value'=>function($model){return('userprofileimage/'.$model->document_image);},
                ],
                 'address',
                 'suburb',
                 'city',
                 'state',
//                 'created_at',
//                 'updated_at',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
