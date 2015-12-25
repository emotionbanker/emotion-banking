<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = 'Update specific style for: ' . $model->s_b_id . ' Bank';
$this->params['breadcrumbs'][] = ['label' => 'Styles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-update">
    <?= $this->render('_form', [
        'model' => $model,
        'styles' => $styles
    ]) ?>

</div>
