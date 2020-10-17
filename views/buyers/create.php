<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Create Buyers';
?>
<div class="users-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
