<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'brand') ?>

    <?= $form->field($model, 'part_number') ?>

    <?= $form->field($model, 'secondary_part_number') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'platinum_price') ?>

    <?php // echo $form->field($model, 'gold_price') ?>

    <?php // echo $form->field($model, 'green_price') ?>

    <?php // echo $form->field($model, 'converter_value') ?>

    <?php // echo $form->field($model, 'converter_ceramic_weight') ?>

    <?php // echo $form->field($model, 'platinum_ppt') ?>

    <?php // echo $form->field($model, 'palladium_ppt') ?>

    <?php // echo $form->field($model, 'rhodium_ppt') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
