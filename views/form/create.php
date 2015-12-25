<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Form */

$this->title = 'Neue fragebögen';
$this->params['breadcrumbs'][] = ['label' => 'Fragebögen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
