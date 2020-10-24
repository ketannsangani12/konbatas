<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BankAccounts */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-6">
        <div class="bank-accounts-form box box-primary">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ; ?>
            <div class="box-body table-responsive">

                <?= $form->field($model, 'user_id')->textInput() ?>

                <?= $form->field($model, 'account_number')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'account_name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'swift_code')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'document_image')->fileInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'suburb')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

        <!--        --><?//= $form->field($model, 'created_at')->textInput() ?>
        <!---->
        <!--        --><?//= $form->field($model, 'updated_at')->textInput() ?>

            </div>
            <div class="box-footer">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
