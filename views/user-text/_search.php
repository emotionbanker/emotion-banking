<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\UserTextSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-text-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ut_id') ?>

    <?= $form->field($model, 'p_id') ?>

    <?= $form->field($model, 'b_id') ?>

    <?= $form->field($model, 'l_id') ?>

    <?= $form->field($model, 't_id') ?>

    <?php // echo $form->field($model, 'isStart') ?>

    <?php // echo $form->field($model, 'isEnd') ?>

    <div class="form-group">
        <?= Html::submitButton('Suche', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
