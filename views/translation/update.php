<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Question */

$this->title = 'Aktualisieren Übersetzung für Frage #' . $model->t_fr_id;
$this->params['breadcrumbs'][] = ['label' => 'Übersetzungen', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tr_id, 'url' => ['view', 'id' => $model->tr_id]];
$this->params['breadcrumbs'][] = 'Aktualisieren';
?>
<div class="question-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
