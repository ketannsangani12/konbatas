<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Countries */

$this->title = 'Create Countries';
$this->params['breadcrumbs'][] = ['label' => 'Countries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="countries-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
