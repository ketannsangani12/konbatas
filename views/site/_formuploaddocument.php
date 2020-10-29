<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\money\MaskMoney;

/* @var $this yii\web\View */
/* @var $model app\models\Packages */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-6">

        <div class="packages-form box box-primary">
            <?php $form = ActiveForm::begin(); ?>
            <div class="box-body table-responsive">



                <?= $form->field($model, 'documentid')->fileInput() ?>


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
                    'data' => \yii\helpers\ArrayHelper::map(\app\models\Countries::find()->asArray()->all(), 'ID', 'name'),

                    //'data' => $data,
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

                <?= $form->field($model, 'latitude')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'longitude')->textInput(['maxlength' => true]) ?>





            </div>
            <div class="box-footer">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-flat']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>