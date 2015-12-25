<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = 'Aktualisieren Group: ' . ' ' . $model->p_id;
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->p_id, 'url' => ['view', 'id' => $model->p_id]];
$this->params['breadcrumbs'][] = 'Aktualisieren';
?>
<div class="group-update">




    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
