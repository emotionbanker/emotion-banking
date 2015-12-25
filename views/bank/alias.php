<?php

use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = 'Platzhalter für:';
$this->params['breadcrumbs'][] = ['label' => 'Banken', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$model = new \app\models\Alias();
?>
<div class="bank-view">
	<h4><?php echo join(', ', ArrayHelper::map($banks, 'b_id', 'bezeichnung')) ?></h4>
	<?php $form = ActiveForm::begin(['method'=>'post'])?>
		<table class="table table-bordered">
			<tr>
				<th>Platzhalter</th>
				<th>Ersetzen durch</th>
				<th>Funktionen</th>
			</tr>
			<?php foreach($aliases as $key => $alias): ?>
				<?php if ($alias['cnt'] == count($banks)):?>

					<tr>

						<td><input class="form-control" type="text" name="alias[<?php echo $key; ?>][original]" value="<?php echo $alias['original'] ?>"/></td>
						<td><input class="form-control" type="text" name="alias[<?php echo $key; ?>][alias]" value="<?php echo $alias['alias'] ?>"/></td>
						<td><input type="button" class="btn btn-success" name="save-<?php echo $key; ?>" value="Save"> &nbsp; <input type="button" class="btn btn-danger" name="delete-<?php echo $key; ?>" value="Löschen"></td>
					</tr>

				<?php endif;?>
			<?php endforeach;?>

			<tr>
				<td><input class="form-control" type="text" name="alias[new][original]" value=""/></td>
				<td><input class="form-control" type="text" name="alias[new][alias]" value=""/></td>
				<td><input type="button" class="btn btn-success" name="add" value="Ersetzen"></td>

			</tr>
		</table>
	<?php echo \yii\helpers\Html::hiddenInput('action', ''); ?>
	<?php $form->end(); ?>
	<script type="text/javascript">
		window.onload = function() {
			$('input[type=button]').click(function(){
				var name = $(this).attr('name');
				var form = $(this).parents('form');
				console.log(form);
				form.find('input[name=action]').val(name);
				form.submit();
			});
		};
	</script>

</div>
