<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FormSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'f_id') ?>

    <?= $form->field($model, 'f_klasse') ?>

    <?= $form->field($model, 'f_p_id') ?>

    <?= $form->field($model, 'reihenfolge') ?>

    <?= $form->field($model, 'history') ?>

    <div class="form-group">
        <?= Html::submitButton('Suche', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
