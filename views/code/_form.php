<?php

use app\assets\MultipleSelectAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \app\models\Bank;
use \app\models\Group;
use yii\helpers\ArrayHelper;
use dosamigos\multiselect\MultiSelect;
MultipleSelectAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Code */
/* @var $form yii\widgets\ActiveForm */


$banks =  \app\helpers\InputHelper::getDropdownOptions('app\models\Bank', 'b_id', 'bezeichnung', true);
$groups = \app\helpers\InputHelper::getDropdownOptions('app\models\Group', 'p_id', 'bezeichnung', true);

?>

<div class="code-form">
	<h4>Für welche benutzer wollen sie codes erzeugen?</h4>
    <?php $form = ActiveForm::begin(); ?>

    <!--<?= $form->field($model, 'z_b_id')->dropDownList($banks) ?>

    <?= $form->field($model, 'z_p_id')->dropDownList($groups) ?>-->

    <div class="form-group <?php if(isset($model->errors['z_b_id'])) : ?> has-error <?php endif;?>">
        <label for="">Bank</label>
        <?= MultiSelect::widget([
            'data' => $banks,
            'name' => 'Code[z_b_id]',
            'clientOptions' => [
                'maxHeight' => 300,
                'enableCaseInsensitiveFiltering' => true,
                'buttonWidth' => '400px'
            ],
            'options' => [
                'multiple' => false,
                'nonSelectedValue' => 0,
            ],
            'value' => $model->z_b_id
        ]) ?>
        <div class="help-block"><?php if(isset($model->errors['z_b_id'])) echo $model->errors['z_b_id'][0]; ?> </div>
    </div>

    <div class="form-group <?php if(isset($model->errors['z_p_id'])) : ?> has-error <?php endif;?>">
        <label for="">Benutzergruppe</label>
        <?= MultiSelect::widget([
            'data' => $groups,
            'name' => 'Code[z_p_id]',
            'clientOptions' => [
                'maxHeight' => 300,
                'enableCaseInsensitiveFiltering' => true,
                'buttonWidth' => '400px'
            ],
            'options' => [
                'multiple' => false
            ],
            'value' => $model->z_p_id
        ]) ?>
        <div class="help-block"><?php if(isset($model->errors['z_p_id'])) echo $model->errors['z_p_id'][0]; ?> </div>
    </div>

    <?= $form->field($model, 'count')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Anlegen' : 'Aktualisieren', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <style>
        label {
            display: block;
        }
        .dropdown-menu > li > a {
            padding: 8px 30px;
        }
    </style>

</div>
