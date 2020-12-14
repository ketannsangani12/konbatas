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

        <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?php
        $properties = \app\models\Countries::find()->asArray()->all();
        //print_r($properties);exit;
        if(!empty($properties)){
            foreach ($properties as $property){
                $data[$property['ID']] = $property['name'];
            }
        }
        ?>
        <?= $form->field($model, 'country')->widget(\kartik\select2\Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select a Country ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
        <?=
        $form->field($model, 'state')->widget(\kartik\depdrop\DepDrop::classname(), [
            'data' => (!$model->isNewRecord)?\yii\helpers\ArrayHelper::map(\app\models\States::find()->where(['country_id'=>$model->country])->asArray()->all(), 'ID', 'name'):[],
            'options' => ['placeholder' => 'Select ...'],
            'type' => \kartik\depdrop\DepDrop::TYPE_SELECT2,
            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
            'pluginOptions' => [
                'depends' => ['users-country'],
                'url' => \yii\helpers\Url::to(['/countries/states']),
                'loadingText' => 'Loading States ...',
            ]
        ]);
        ?>
        <?= $form->field($model, 'business_type')->dropDownList([ 'Broker' => 'Broker', 'Scrap Collector' => 'Scrap Collector', 'Muffler Shop' => 'Muffler Shop', 'Wrecking Yard' => 'Wrecking Yard']) ?>

        <?= $form->field($model, 'membership_level')->dropDownList([ 'Green' => 'Green', 'Gold' => 'Gold', 'Silver' => 'Silver']) ?>

        <?= $form->field($model, 'average_converters')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'contact_no')->textInput(['maxlength' => true]) ?>

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