<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BankSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bank-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'b_id') ?>

    <?= $form->field($model, 'bezeichnung') ?>

    <?= $form->field($model, 'klasse') ?>

    <div class="form-group">
        <?= Html::submitButton('Suche', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
