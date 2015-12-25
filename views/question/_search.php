<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\QuestionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'fr_id') ?>

    <?= $form->field($model, 'frage') ?>

    <?= $form->field($model, 'display') ?>

    <?= $form->field($model, 'antworten') ?>

    <?= $form->field($model, 'suche') ?>

    <div class="form-group">
        <?= Html::submitButton('Suche', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
