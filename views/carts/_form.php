<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Carts */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
<div class="col-md-6">
<div class="carts-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">


        <?= $form->field($model, 'status')->dropDownList(($delivery==true)?['Delivered'=>'Delivered']:[ 'Accepted' => 'Accepted',  'Rejected' => 'Rejected' ], ['prompt' => '']) ?>
        <?php
        if(Yii::$app->user->id==1){
            echo $form->field($model, 'address')->textarea();

        }
        if($delivery==true){
           echo $form->field($model, 'receipt')->fileInput();
        }

        ?>


    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>
</div>