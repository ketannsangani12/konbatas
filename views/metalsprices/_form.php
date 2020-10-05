<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MetalsPrices */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-6">
<div class="metals-prices-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'platinum_price')->textInput() ?>

        <?= $form->field($model, 'palladium_price')->textInput() ?>

        <?= $form->field($model, 'rhodium_price')->textInput() ?>


    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>
    </div>