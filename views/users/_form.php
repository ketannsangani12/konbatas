<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-6">
<div class="users-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive ">
        <div class="row">
         <div class="col-md-8">
        <?= $form->field($model, 'role')->dropDownList(['Seller'=>'Seller','Buyer'=>'Buyer'], ['id'=>'role']); ?>

        <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

         </div>
</div>
        </div>
    <div class="box-footer">
        <div class="row">
        <div class="col-md-8">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-flat']) ?>
            </div>
            </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>
    </div>