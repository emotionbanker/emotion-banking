<?php

use yii\helpers\Html;
use app\models\Settings;

$style = Settings::getSetting('style');
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
$webRoot = Yii::$app->getUrlManager()->getBaseUrl();
?>
<link href="<?= $webRoot ?>/css/styles/<?= $style ?>/style.css" rel="stylesheet">
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you!
    </p>

</div>
