<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Announcements */

$this->title = 'Update Announcements: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Announcements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="announcements-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
