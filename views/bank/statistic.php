<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = $model->bezeichnung . ' - Statistik';
$this->params['breadcrumbs'][] = ['label' => 'Banken', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-view">
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			[
				'label' => 'Personengruppe',
				'attribute' => 'bezeichnung',
				'width' => '20%'
			],
			[
				'label' => 'Anz. Codes',
				'attribute' => 'tic_count',
				'pageSummary' => true,
				'width' => '20%'
			],
			[
				'label' => 'Komplett',
				'attribute' => 'bused',
				'pageSummary' => true,
				'width' => '20%'
			],
			[
				'label' => 'nur 50 oder mehr',
				'attribute' => 'bused50',
				'pageSummary' => true,
				'width' => '20%'
			],
			[
				'label' => 'Gesamt in Auswertung',
				'attribute' => 'busedtot',
				'pageSummary' => true,
				'width' => '20%'
			],
		],
		'showPageSummary' => true
	]);

	$codes = \app\models\Code::find()->andWhere(['used'=>1, 'z_b_id' => $model->b_id])->all();
	$count = 0;
	$ips = array();
	$time = 0;

	foreach ($codes as $code) {
		$count++;
		$meta = \app\models\Meta::findOne(['m_z_id' => $code->z_id]);
		$time += ($meta->time_end - $meta->time_start);
		if (! isset($ips[$meta->ip])) {
			$ips[$meta->ip] = 1;
		} else {
			$ips[$meta->ip]++;
		}

	}
	$mip = '';
	$max = 0;
	foreach ($ips as $ip => $ipc) {
		if ($ipc > $max) {
			$max = $ipc;
			$mip = $ip;
		}
	}

	if ($count) {
		$time = $time / $count;
	}


	?>

	<h3>Metadaten</h3>
	Benutzer gesamt: <b><?php echo \app\models\Code::find()->andWhere(['used'=>1, 'z_b_id' => $model->b_id])->count() ?></b>
	<br/>
	Eindeutige IP- Adressen: <b><?php echo count($ips) ?></b>
	<br/>
	Am häufigsten eingetragene IP- Adresse: <b><?php echo $mip?></b> (<b><?php echo $max?></b> mal)
	<br/>
	<?php if ($count):?>
	Durchschnittliche Ausfülldauer: <b><?php echo date("H:i:s", $time - 60*60) ?></b>;
	<?php endif;?>

</div>
