<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
<div class="col-md-6">
<div class="products-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body table-responsive">
        <h4>Update Product - <?php echo  $model->part_number;?></h4>
        <br>
        <?php
        $properties = \app\models\Categories::find()->asArray()->all();
        //print_r($properties);exit;
        if(!empty($properties)){
            foreach ($properties as $property){
                $data[$property['id']] = $property['name'];
            }
        }
        ?>
        <?= $form->field($model, 'category_id')->widget(\kartik\select2\Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select a Category ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

        <?= $form->field($model, 'brand')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'part_number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'secondary_part_number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'platinum_price')->textInput() ?>

        <?= $form->field($model, 'gold_price')->textInput() ?>

        <?= $form->field($model, 'green_price')->textInput() ?>

        <?= $form->field($model, 'converter_value')->textInput() ?>

        <?= $form->field($model, 'converter_ceramic_weight')->textInput() ?>

        <?= $form->field($model, 'platinum_ppt')->textInput() ?>

        <?= $form->field($model, 'palladium_ppt')->textInput() ?>

        <?= $form->field($model, 'rhodium_ppt')->textInput() ?>

        <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive',  ], ['prompt' => '']) ?>


    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>
</div>