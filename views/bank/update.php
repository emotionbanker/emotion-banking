<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = 'Banken: ' . ' ' . $model->b_id;
$this->params['breadcrumbs'][] = ['label' => 'Banken', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->b_id, 'url' => ['view', 'id' => $model->b_id]];
$this->params['breadcrumbs'][] = 'Bearbeiten';
?>
<div class="bank-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
