<?php

use app\assets\MultipleSelectAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\multiselect\MultiSelect;

MultipleSelectAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Question */
/* @var $form yii\widgets\ActiveForm */

$translationId = $model->tr_id;
if(empty($translationId)) {
    $questions = ['' => 'Bitte wählen Sie'] + ArrayHelper::map(app\models\Question::find()->orderBy('fr_id')->all(),'fr_id', function($model, $defaultValue) {
            return $model->fr_id.' - '.$model->frage;
        });
}else{
    $questionModel[] = app\models\Question::findOne($model->t_fr_id);
    $questions =  ['' => 'Bitte wählen Sie'] + ArrayHelper::map($questionModel,'fr_id', 'frage');
}
$languages = ['' => 'Bitte wählen Sie'] + ArrayHelper::map(app\models\Language::find()->orderBy('l_id')->all(),'l_id', 'name');
?>

<div class="question-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group <?php if(isset($model->errors['t_fr_id'])) : ?> has-error <?php endif;?>">
        <label for="">Frage</label>
        <?= MultiSelect::widget([
            'data' => $questions,
            'name' => 'Translation[t_fr_id]',
            'clientOptions' => [
                'maxHeight' => 300,
                'enableCaseInsensitiveFiltering' => true,
                'buttonWidth' => '800px'
            ],
            'options' => [
                'disabled' => !empty($translationId),
                'multiple' => false,
                'nonSelectedValue' => 0,
            ],
            'value' => $model->t_fr_id
        ]) ?>
        <div class="help-block"><?php if(isset($model->errors['t_fr_id'])) echo $model->errors['t_fr_id'][0]; ?> </div>
    </div>

    <div class="form-group <?php if(isset($model->errors['t_l_id'])) : ?> has-error <?php endif;?>">
        <label for="">Sprache</label>
        <?= MultiSelect::widget([
            'data' => $languages,
            'name' => 'Translation[t_l_id]',
            'clientOptions' => [
                'maxHeight' => 300,
                'enableCaseInsensitiveFiltering' => true,
                'buttonWidth' => '800px'
            ],
            'options' => [
                'disabled' => !empty($translationId),
                'multiple' => false,
                'nonSelectedValue' => 0,
            ],
            'value' => $model->t_l_id
        ]) ?>
        <div class="help-block"><?php if(isset($model->errors['t_l_id'])) echo $model->errors['t_l_id'][0]; ?> </div>
    </div>

    <?= $form->field($model, 'frage')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'antworten')->textarea(['rows' => 6]) ?>

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
