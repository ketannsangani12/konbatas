<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\States */

$this->title = 'Update States: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'States', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="states-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
