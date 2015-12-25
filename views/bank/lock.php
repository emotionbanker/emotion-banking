<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = $model->bezeichnung;
$this->params['breadcrumbs'][] = ['label' => 'Banken', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['bank'] = $model;
?>
<div class="bank-view">
	<?php if (! $model->isLocked()): ?>
		<h4>Bank ist für Eingaben geöffnet</h4>
		<h4><strong><?php echo $model->bezeichnung?></strong> <?php echo Html::a('sperren', Url::toRoute('/bank/'.$model->b_id.'/lock-unlock'), ['style'=>'color:green']);?></h4>
		<br/><br/>
	<?php else: ?>
		<h4>Bank ist gesperrt</h4>
		<h4><strong><?php echo $model->bezeichnung?></strong> <?php echo Html::a('öffnen', Url::toRoute('/bank/'.$model->b_id.'/lock-unlock'), ['style'=>'color:red']);?></h4>
		<br/><br/>
	<?php endif;?>


	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			[
				'attribute' => 'bezeichnung',
				'format' => 'raw'
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{lock}',
				'buttons' => [
					'lock' => function($url, $model, $key) {
						$bank = $this->params['bank'];

						if (! $bank->isLocked($model->p_id)) {
							$icon = 'fa-lock';
							$text = 'sperren';
							$color = 'green';
						} else {
							$icon = 'fa-unlock';
							$text = 'sperren';
							$color = 'red';
						}
						return Html::a('<i style="color:'.$color.'" class="fa ' . $icon . '"></i>', ['/bank/' . $bank->b_id . '/lock-unlock', 'p_id'=>$model->p_id], [
							'title' => Yii::t('yii', $text),
						]);

					},
				]
			],
		],
	]);
	?>
</div>
