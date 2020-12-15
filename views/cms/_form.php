<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Cms */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-6">
<div class="cms-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'title')->textInput([]) ?>

        <?= $form->field($model, 'picture')->fileInput(['rows' => 6]) ?>
        <p style="color: red;">Please upload image with 400x400.</p>

        <?= $form->field($model, 'content')->widget(\marqu3s\summernote\Summernote::className(), [
            'clientOptions' => [

            ]
        ]); ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>
    </div>