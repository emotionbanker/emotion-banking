<?php

use app\assets\MultipleSelectAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\multiselect\MultiSelect;
MultipleSelectAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\UserText */
/* @var $form yii\widgets\ActiveForm */

$banks = ['0' => 'Alle']+ArrayHelper::map(app\models\Bank::find()->orderBy('klasse')->all(),'b_id', 'bezeichnung');
$groups = ['0' => 'Alle']+ ArrayHelper::map(app\models\Group::find()->orderBy('bezeichnung')->all(),'p_id', 'bezeichnung');
$languages = ['0' => 'Default']+ ArrayHelper::map(app\models\Language::find()->orderBy('name')->all(),'l_id', 'name');
$texts = ArrayHelper::map(app\models\Text::find()->orderBy('name')->all(),'t_id', 'name');

?>

<div class="user-text-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if($model->exists()) : ?>

        <?= $form->field($model, 'p_id')->dropDownList($groups); ?>

        <?= $form->field($model, 'b_id')->dropDownList($banks) ?>

    <?php else: ?>
        <div class="form-group <?php if(isset($model->errors['p_id'])) : ?> has-error <?php endif;?>">
            <label for="">Benutzer</label>
            <?= MultiSelect::widget([
                'data' => $groups,
                'name' => 'UserText[p_id]',
                'clientOptions' => [
                    'maxHeight' => 300,
                    'enableCaseInsensitiveFiltering' => true,
                    'buttonWidth' => '400px'
                ],
                'options' => [
                    'multiple' => true
                ],
                'value' => $model->p_id
            ]) ?>
            <div class="help-block"><?php if(isset($model->errors['p_id'])) echo $model->errors['p_id'][0]; ?> </div>
        </div>

        <div class="form-group <?php if(isset($model->errors['b_id'])) : ?> has-error <?php endif;?>">
            <label for="">Bank</label>
            <?= MultiSelect::widget([
                'data' => $banks,
                'name' => 'UserText[b_id]',
                'clientOptions' => [
                    'maxHeight' => 300,
                    'enableCaseInsensitiveFiltering' => true,
                    'buttonWidth' => '400px'
                ],
                'options' => [
                    'multiple' => true
                ],
                'value' => $model->b_id
            ]) ?>
            <div class="help-block"><?php if(isset($model->errors['b_id'])) print_r($model->errors['b_id'][0]); ?> </div>
        </div>

    <?php endif; ?>

    <?= $form->field($model, 'l_id')->dropDownList($languages) ?>

    <?= $form->field($model, 't_id')->dropDownList($texts) ?>

    <div class="hidden">
        <?= $form->field($model, 'isStart')->textInput() ?>
        <?= $form->field($model, 'isEnd')->textInput() ?>
    </div>


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