<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Code */

$this->title = 'Aktualisieren Code: ' . ' ' . $model->z_id;
$this->params['breadcrumbs'][] = ['label' => 'Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->z_id, 'url' => ['view', 'id' => $model->z_id]];
$this->params['breadcrumbs'][] = 'Aktualisieren';
?>
<div class="code-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
