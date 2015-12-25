<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Settings;
$style = Settings::getSetting('style');

/* @var $this yii\web\View */
$this->title = 'Victor 2016';
$languages = ['default' => 'Default']+ ArrayHelper::map(app\models\Language::find()->all(),'l_id', 'name');
$webRoot = Yii::$app->getUrlManager()->getBaseUrl();
?>
<link href="<?= $webRoot ?>/css/styles/<?= $style ?>/style.css" rel="stylesheet">

<div class="form-div">

	<?php if ($error): ?>
		<div class="alert alert-danger" role="alert">
			<?php echo $error; ?>
		</div>
	<?php endif;?>
    <?php echo date_default_timezone_get (); ?>
	<h4>Wenn Sie einen persönlichen Code für das Umfragesystem haben, geben Sie diesen bitte hier ein:</h4>
	<?php $form = ActiveForm::begin();?>
		<?php echo $form->field($model, 'code')->textInput();?>
		<?php echo $form->field($model, 'language')->dropDownList($languages, array('disabled'=>'true', 'readonly' => 'true'));?>
        <input type="text" style="display: none; visibility: hidden" value="default" name="AnketForm[language]">
		<input type="submit" class="btn btn-primary btn-block" value="Umfrage beginnen">
	<?php ActiveForm::end();?>
</div>