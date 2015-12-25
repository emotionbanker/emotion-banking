<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Form */

$this->title = 'Preview';
$lang = Yii::$app->request->get('lang');
?>
<div class="form-view">

	<div class="form-group">
		<label for="">Sprachauswahl:</label>
		<?php echo Html::dropDownList(
			'lang',
			isset($lang) ? $lang : 0,
			\app\helpers\InputHelper::getDropdownOptions('app\models\Language', 'l_id', 'name', false, true, true),
			['class'=> 'form-control', 'id' => 'changeLang']) ?>
		<script>
			window.onload = function(){
				$('#changeLang').change(function(){
					var lang = $(this).val();
					if (window.location.href.indexOf('lang') == -1) {
						window.location.href = window.location.href + '&lang=' + lang;
					} else {
						window.location.href = window.location.href.replace(/[0-9]+$/, lang);
					}

				});
			}
		</script>
	</div>


	<?php $form = ActiveForm::begin();?>
	<?php
		$i = 0;
		$pos = 0;
		$question = $model->getQuestions();
        if($question == 0){?>
            <div role="alert" class="alert alert-danger">Der Fragebogen kann nicht geparst werden. Dies kann an nicht existierenden Fragen IDs, ungültigen Tags, etc. liegen. Bitte überprüfen sie ihre Eingaben</div>
        <?php }elseif(is_array($question) && count($question)== 0){?>
            <div role="alert" class="alert alert-danger">Es ist nichts zum Anzeigen. Fragebogen ist leer!</div>
        <?php }else{
            while ($pos < count($question)) {
                switch ($question[$pos]['cmd'])
                {
                    case 'header':
                        echo "<h4>".$question[$pos]['text']."</h4>";
                        $pos++;
                        break;

                    case 'pagebreak':
                        echo "<div class='page-break'></div>";
                        $pos++;
                        break;

                    case 'question':

                        $multi = false;
                        $m = array();


                        while (
                            (count($a = @explode(";", $question[$pos]['antworten'])) <= 6) &&
                            (count($a = @explode(";", $question[$pos]['antworten'])) > 1) &&
                            (isset($question[$pos]['antworten']) && isset($question[$pos+1]['antworten'])) &&
                            ($question[$pos]['antworten'] == $question[$pos+1]['antworten']) &&
                            ($question[$pos+1]['cmd'] == "question")
                        ) {
                            $multi = true;

                            $m[] = $question[$pos];

                            $pos ++;
                        }

                        if ($multi) { $m[] = $question[$pos]; }

                        if (!$multi) {
                            //print_r($question[$pos]);
                            echo \app\widgets\Question::widget([
                                'questions' => [
                                    $question[$pos]
                                ],
                                'num' => $pos,
                                'showConditions' => true,
                                'translate' => true
                            ]);
                            //echoQuestion($all[$pos],$pos,$qu[$pos + 1], true, true);
                        } else {
                            echo \app\widgets\Question::widget([
                                'questions' => $m,
                                'num' => $pos,
                                'showConditions' => true,
                                'translate' => true,
                                'multi' => true
                            ]);
                            //echoMultiQuestion($m,$pos,$qu, true, true);
                        }



                        $pos++;

                        break;
                }
            }
        }
	?>
	<?php $form->end();?>
</div>
