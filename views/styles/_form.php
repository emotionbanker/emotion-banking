<?php

use app\assets\MultipleSelectAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\multiselect\MultiSelect;
use kartik\grid\GridView;
MultipleSelectAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Form */
/* @var $form yii\widgets\ActiveForm */
$banks = ['' => 'Bitte wählen Sie'] + ArrayHelper::map(app\models\Bank::find()->orderBy('bezeichnung')->all(),'b_id', 'bezeichnung');
$groups = ['' => 'Bitte wählen Sie'] + ArrayHelper::map(app\models\Group::find()->orderBy('bezeichnung')->all(),'p_id', 'bezeichnung');
$pageSize = Yii::$app->session->get('pageSize',Yii::$app->params['defaultPageSize']);


?>
<div class="form-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group <?php if(isset($model->errors['s_b_id'])) : ?> has-error <?php endif;?>">
        <label for="">Bank</label>
        <?= MultiSelect::widget([
            'data' => $banks,
            'name' => 'Style[s_b_id]',
            'clientOptions' => [
                'maxHeight' => 300,
                'enableCaseInsensitiveFiltering' => true,
                'buttonWidth' => '400px'
            ],
            'options' => [
                'multiple' => false,
                'nonSelectedValue' => 0,
            ],
            'value' => $model->s_b_id
        ]) ?>
        <div class="help-block"><?php if(isset($model->errors['s_b_id'])) echo $model->errors['s_b_id'][0]; ?> </div>
    </div>

    <?= $form->field($model, 's_p_id')->dropDownList($groups) ?>

    <?= $form->field($model, 'style')->dropDownList($styles) ?>

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