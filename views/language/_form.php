<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Language */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="language-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'short')->textInput(['maxlength' => 3]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 60]) ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => 60]) ?>

    <?= $form->field($model, 'message')->textarea(['maxlength' => 254]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Anlegen' : 'Aktualisieren', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
