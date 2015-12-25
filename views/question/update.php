<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Question */

$this->title = 'Aktualisieren Question: ' . ' ' . $model->fr_id;
$this->params['breadcrumbs'][] = ['label' => 'Fragen', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fr_id, 'url' => ['view', 'id' => $model->fr_id]];
$this->params['breadcrumbs'][] = 'Aktualisieren';
?>
<div class="question-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
