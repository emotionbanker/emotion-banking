<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Language */

$this->title = 'Aktualisieren Sprache: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sprachen', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->l_id]];
$this->params['breadcrumbs'][] = 'Ändern';
?>
<div class="language-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
