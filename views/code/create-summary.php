<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Code */

$this->title = 'Zugangscodes für Bank:' . $bank->bezeichnung;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="code-create">
	<h4><?php echo $count?> Zugangscode(s) für diese Bank wurde(n) neu erzeugt </h4>
	<table class="table table-bordered">
		<tr>
			<th>Code</th>
		</tr>
		<?php foreach ($codes as $code): ?>
			<tr>
				<td><?php echo $code; ?></td>
			</tr>
		<?php endforeach;?>
	</table>
</div>
