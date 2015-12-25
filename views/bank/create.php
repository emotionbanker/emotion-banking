<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = 'Neue Bank';
$this->params['breadcrumbs'][] = ['label' => 'Banken', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
