<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Categories */

$this->title = 'Create Categories';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
