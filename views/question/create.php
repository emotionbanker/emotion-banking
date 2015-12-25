<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Question */

$this->title = 'Neue Frage';
$this->params['breadcrumbs'][] = ['label' => 'Fragen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
