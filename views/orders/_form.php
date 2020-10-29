<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Carts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carts-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'order_no')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'seller_id')->textInput() ?>

        <?= $form->field($model, 'buyer_id')->textInput() ?>

        <?= $form->field($model, 'currency')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'latitude')->textInput() ?>

        <?= $form->field($model, 'longitude')->textInput() ?>

        <?= $form->field($model, 'country_id')->textInput() ?>

        <?= $form->field($model, 'state_id')->textInput() ?>

        <?= $form->field($model, 'subtotal')->textInput() ?>

        <?= $form->field($model, 'delivery_fee')->textInput() ?>

        <?= $form->field($model, 'tax')->textInput() ?>

        <?= $form->field($model, 'total')->textInput() ?>

        <?= $form->field($model, 'type')->dropDownList([ 'Delivery' => 'Delivery', 'Pickup' => 'Pickup', ], ['prompt' => '']) ?>

        <?= $form->field($model, 'status')->dropDownList([ 'Processing' => 'Processing', 'Accepted' => 'Accepted', 'Delivered' => 'Delivered', 'Rejected' => 'Rejected', 'Retracted' => 'Retracted', ], ['prompt' => '']) ?>

        <?= $form->field($model, 'order_placed')->textInput() ?>

        <?= $form->field($model, 'payment_date')->textInput() ?>

        <?= $form->field($model, 'created_at')->textInput() ?>

        <?= $form->field($model, 'updated_at')->textInput() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
