<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */

$this->title = 'Victor 2016';
$webRoot = Yii::$app->getUrlManager()->getBaseUrl();
?>

<link href="<?= $webRoot ?>/css/styles/<?= $style ?>/style.css" rel="stylesheet">
<div class="content">
	<?php echo \app\models\Text::findOne($text->t_id)->text; ?>
</div>
