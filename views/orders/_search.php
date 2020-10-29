<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CartsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'order_no') ?>

    <?= $form->field($model, 'seller_id') ?>

    <?= $form->field($model, 'buyer_id') ?>

    <?= $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'latitude') ?>

    <?php // echo $form->field($model, 'longitude') ?>

    <?php // echo $form->field($model, 'country_id') ?>

    <?php // echo $form->field($model, 'state_id') ?>

    <?php // echo $form->field($model, 'subtotal') ?>

    <?php // echo $form->field($model, 'delivery_fee') ?>

    <?php // echo $form->field($model, 'tax') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'order_placed') ?>

    <?php // echo $form->field($model, 'payment_date') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
