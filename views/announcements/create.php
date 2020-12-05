<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Announcements */

$this->title = 'Create Announcements';
$this->params['breadcrumbs'][] = ['label' => 'Announcements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="announcements-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
