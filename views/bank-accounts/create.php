<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BankAccounts */

$this->title = 'Create Bank Accounts';
$this->params['breadcrumbs'][] = ['label' => 'Bank Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-accounts-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
