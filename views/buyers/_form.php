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
         <div class="col-md-10">

        <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

        <?php if($model->isNewRecord){ ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
<?php }?>
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
        <?= $form->field($model, 'address')->textarea(['maxlength' => true]) ?>
        <?= $form->field($model, 'offering_pickup')->dropDownList([ 'Yes' => 'Yes', 'No' => 'No']) ?>

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