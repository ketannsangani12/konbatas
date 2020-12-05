<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Announcements */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-6">
<div class="announcements-form box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $this->title;?></h3>
    </div>
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">


        <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>


    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
    </div>
</div>