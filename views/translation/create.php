<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Question */

$this->title = 'Neue Übersetzung';
$this->params['breadcrumbs'][] = ['label' => 'Übersetzungen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
