<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
$this->title = 'Victor 2016';
$webRoot = Yii::$app->getUrlManager()->getBaseUrl();
?>
<link href="<?= $webRoot ?>/css/styles/<?= $style ?>/style.css" rel="stylesheet">
<div class="anket-form">
	<div class="head">
		<div class="progress">
			<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percent;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent;?>%;">
				<?php echo $percent;?>%
			</div>
		</div>
	</div>
	<?php $form = ActiveForm::begin();?>
	<div class="anket-content">
		<?php
		$i = 0;
		$pos = $anket->getPos($questions, $status);
		$abort = false;

		while (!$abort && $pos < count($questions))
		{
			if ($anket->checkCondition($questions[$pos]['condition']))
			{
				switch ($questions[$pos]['cmd'])
				{
					case 'header':
						//
						echo "<h4>" . \app\models\Bank::applyAlias($bank, $questions[$pos]['text']) . "</h4>";
						$pos++;

						break;

					case 'pagebreak':

						$abort = true;
						$pos++;

						break;


					case 'question':

						$multi = false;
						$m = array();

						while (
							(count($a = @explode(";", $questions[$pos]['antworten'])) <= 6) &&
							(count($a = @explode(";", $questions[$pos]['antworten'])) > 1) &&
							(isset($questions[$pos]['antworten']) && isset($questions[$pos+1]['antworten'])) &&
							($questions[$pos]['antworten'] == $questions[$pos+1]['antworten']) &&
							($questions[$pos+1]['cmd'] == "question")
						)
						{
							$multi = true;

							if ($anket->checkCondition($questions[$pos]['condition'])) $m[] = $questions[$pos];

							$pos ++;
						}

						if ($multi && $anket->checkCondition($questions[$pos]['condition'])) {
							$m[] = $questions[$pos];
						}

						if (!$multi) {
							//echoQuestion($all[$pos],$pos,$qu[$pos + 1]);
							echo \app\widgets\Question::widget([
								'questions' => [
									$questions[$pos]
								],
								'num' => $pos,
								'showConditions' => false,
								'translate' => false,
								'preview' => false
							]);
						} else {
							echo \app\widgets\Question::widget([
								'questions' => $m,
								'num' => $pos,
								'showConditions' => true,
								'translate' => false,
								'multi' => true,
								'preview' => false
							]);
						}

						$pos++;

						break;
				}
			}
			else
			{
				$pos++;
			}
		}
		?>
	</div>
	<div class="foot">
		<input class="btn btn-success" type="submit" value="<?= Yii::$app->session['anketData']['label'] ?>"/> (<?= Yii::$app->session['anketData']['message'] ?>)
	</div>
	<?php $form::end();?>
</div>
