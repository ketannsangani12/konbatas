<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Faqs */

$this->title = 'Create Faqs';
$this->params['breadcrumbs'][] = ['label' => 'Faqs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faqs-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
