<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\States */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-6">

<div class="states-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">


        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?php
        $properties = \app\models\Countries::find()->asArray()->all();
        //print_r($properties);exit;
        if(!empty($properties)){
            foreach ($properties as $property){
                $data[$property['ID']] = $property['name'];
            }
        }
        ?>
        <?= $form->field($model, 'country_id')->widget(\kartik\select2\Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select a Country ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

        <?= $form->field($model, 'tax')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
