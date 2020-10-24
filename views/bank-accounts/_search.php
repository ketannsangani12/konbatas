<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BankAccountsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bank-accounts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'account_number') ?>

    <?= $form->field($model, 'account_name') ?>

    <?= $form->field($model, 'bank_name') ?>

    <?php  echo $form->field($model, 'swift_code') ?>

    <?php  echo $form->field($model, 'document_image') ?>

    <?php  echo $form->field($model, 'address') ?>

    <?php  echo $form->field($model, 'suburb') ?>

    <?php  echo $form->field($model, 'city') ?>

    <?php  echo $form->field($model, 'state') ?>

    <?php  echo $form->field($model, 'created_at') ?>

    <?php  echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
