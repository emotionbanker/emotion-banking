<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Text */

$this->title = 'Aktualisieren Text: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->t_id]];
$this->params['breadcrumbs'][] = 'Aktualisieren';
?>
<div class="text-update">


    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
