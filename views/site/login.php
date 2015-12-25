<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Settings;

$style = Settings::getSetting('style');
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Login';
$webRoot = Yii::$app->getUrlManager()->getBaseUrl();
?>
<link href="<?= $webRoot ?>/css/styles/<?= $style ?>/style.css" rel="stylesheet">
<div class="site-login">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
        ],
    ]); ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe', [
        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ])->checkbox() ?>

    <div class="form-group">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
