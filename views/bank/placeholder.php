<?php

use app\assets\MultipleSelectAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use dosamigos\multiselect\MultiSelect;
use yii\helpers\ArrayHelper;
MultipleSelectAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = 'Platzhalter';
$this->params['breadcrumbs'][] = ['label' => 'Banken', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$data = ArrayHelper::map(\app\models\Bank::find()->orderBy('bezeichnung')->all(), 'b_id', 'bezeichnung');
?>
<div class="bank-view">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif;?>
	<form action=<?= Url::toRoute("/bank/placeholders/set-alias") ?>>
		<div class="form-group">
			<label for="">Platzhalter setzen für</label>
			<?= MultiSelect::widget([
				'data' => $data,
				'name' => 'bank',
				'clientOptions' => [
					'maxHeight' => 300,
					'enableCaseInsensitiveFiltering' => true,
					'buttonWidth' => '400px'
				],
				'options' => [
					'multiple' => true
				]
			]) ?>
		</div>
		<button class="btn btn-success">Platzhalter für diese Bank bearbeiten</button>
	</form>
	<style>
		label {
			display: block;
		}
		.dropdown-menu > li > a {
			padding: 8px 30px;
		}
	</style>
</div>
