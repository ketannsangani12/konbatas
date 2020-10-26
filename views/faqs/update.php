<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Faqs */

$this->title = 'Update Faqs: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Faqs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="faqs-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
