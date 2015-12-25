<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = 'Neue Style';
$this->params['breadcrumbs'][] = ['label' => 'Styles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-create">

    <?= $this->render('_form', [
        'model' => $model,
        'styles' => $styles
    ]) ?>

</div>
