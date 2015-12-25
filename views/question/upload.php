<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Import Fragen';
$this->params['breadcrumbs'][] = $this->title;?>
<?php if (isset($error) && !empty($error)) : ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error; ?>
    </div>
<?php endif;?>
<?php if (isset($warning) && !empty($warning)) : ?>
    <div class="alert alert-warning" role="alert">
        <?php echo $warning; ?>
    </div>
<?php endif;?>
<div class="question-index">
	<div class="bs-callout bs-callout-warning">
		<h4>ACHTUNG: Quelldatei muss eine Textdatei im Format</h4>
		<p>Frage@Typ@Antwort1;Antwort2;AntwortN@Suchkürzel</p>
	</div>

	<?php if ($imported): ?>
		<h3 style="color: #008000"><?php echo $imported;?> Fragen in die Datenbank aufgenommen, <?php echo $dropped;?> fragen doppelt</h3>
	<?php endif;?>

	<div class="upload-field">
		<?php
			$form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); //important
			echo FileInput::widget([
				'name' => 'filename',
				'options'=>[
					'multiple' => false
				],
				'pluginOptions' => [
					'showPreview' => false,
					'showCaption' => true,
					'showRemove' => true,
					'showUpload' => true
				]

			]);
		?>
	</div>
	<?php ActiveForm::end(); ?>



</div>
