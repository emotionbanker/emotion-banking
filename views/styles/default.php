<?php

use app\assets\MultipleSelectAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Form */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Einstellungen des Standard-Styles';
$this->params['breadcrumbs'][] = ['label' => 'Styles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="form-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'style')->dropDownList($styles) ?>

    <div class="form-group">
        <?= Html::submitButton('Aktualisieren', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>