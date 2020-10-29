<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Carts */

$this->title = 'Update Carts: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Carts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="carts-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
