<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\States */

$this->title = 'Create States';
$this->params['breadcrumbs'][] = ['label' => 'States', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="states-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
