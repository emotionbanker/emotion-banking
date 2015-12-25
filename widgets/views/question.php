<?php

$question = $questions[0];
$hide = $question['hidden'];
$aslist = isset($question['aslist']) ? $question['aslist'] : false;
$horizontal = isset($question['horizontal']) ? $question['horizontal'] : false;

if (Yii::$app->request->get('lang') || Yii::$app->session['anketData']['lang']) {
	$lang = Yii::$app->request->get('lang') ? Yii::$app->request->get('lang') : 0;
	$lang = $lang ? $lang : Yii::$app->session['anketData']['lang'];
	if ($lang != 'default') {
		\app\models\Question::translateQuestion($question, $lang);
	}
}

$answers = explode(";", $question['antworten']);
if (! is_array($answers)) {
	$answers = array($question['antworten']);
}

foreach($answers as $key => $value)
{
	$answers[$key] = trim($value);
}

$nr = $question['pos'];

if ($preview && $question['condition']) {
	$question['frage'] = $question['fr_id'] . ' - ' . "<span style='background-color: lightgreen;'> wenn " . $question['condition'] . "</span> " . $question['frage'];
} else if ($preview) {
	$question['frage'] = $question['fr_id'] . ' - ' . $question['frage'];
}

echo "<input type='hidden' name='q[".$nr."]' value=''/>";
switch($question['display']) {
	case "text":
		?>
		<div class="form-group">
			<label for=""><?php echo $question['frage']?></label>
			<input type='text' class="form-control" name='q[<?php echo $nr ?>]' value='<?php echo $qu ?>' size='90'>
		</div>
		<?php
	break;

	case "multitext":
		?>
		    <div class="form-group">
                <?php
                echo "<table class='table answer'>";
                echo $question['frage']."</br>";

                echo "<thead><tr scope='col'>";
                foreach ($answers as $answer)
                {
                 echo "<th scope='col' class='head'>" . $answer . "</th>";
                }

                $in = 1;
                $i = 0;
                echo '</tr></thead><tbody>';
                echo "<tr>";
                //echo filterQText($q[0]);
                foreach ($answers as $answer)
                {
                    echo "<td class='input' data-title='" . $answer . "'>";
                    echo "<input class='form-control' type='text' name='q[".$nr."][".$i++."]' value='".$qu."' size='15'>";
                    echo "</td>";
                    $in++;
                }
                echo '</tr></tbody></table>';
                ?>
            </div>
		<?php
	break;

	case "radio":
		if ($aslist) {
			?>
            <div class="form-group vertical-group">
                <label for=""><?php echo $question['frage']?></label>
                <?php
                foreach ($answers as $answer)
                {
                    ?>
                    <div class="radio">
                        <label>
                            <input type="radio" name="q[<?php echo $nr; ?>]" value="<?php echo $answer ?>" >
                            <?php echo $answer ?>
                        </label>
                    </div>
                <?php
                }
                ?>
            </div>
			<?php
		} elseif($horizontal) { ?>
            <div class="form-group radio-group">
                <label for=""><?php echo $question['frage']?></label>
                <?php
                foreach ($answers as $answer)
                {
                    ?>
                    <div class="radio" style="width: 20%;float:left">
                        <label>
                            <input type="radio" name="q[<?php echo $nr; ?>]" value="<?php echo $answer ?>" >
                            <?php echo $answer ?>
                        </label>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="clearfix"></div>
        <?php
        }else if (count($answers) > Yii::$app->params['selectbox_limit']) {
			?>
			<div class="form-group" <?php if ($hide) echo " style='display: none;'"?>>
				<label for=""><?php echo $question['frage']?></label>
				<select class="form-control" name='q[<?php echo $nr; ?>]'>
					<?php
					echo "<option value='' selected>---</option>";
					foreach ($answers as $answer)
					{
						echo "<option value'".$answer."'>$answer</option>";
					}
					?>
				</select>
			</div>
			<?php
		} else if (count($answers) > Yii::$app->params['radios_limit']) {

			?>
			<div class="form-group radio-group" <?php if ($hide) echo " style='display: none;'"?>>
				<label for=""><?php echo $question['frage']?></label>
				<?php
				foreach ($answers as $answer)
				{
					?>
					<div class="radio">
						<label>
							<input type="radio" name="q[<?php echo $nr; ?>]" value="<?php echo $answer ?>" >
							<?php echo $answer ?>
						</label>
					</div>
					<?php
				}
				?>
				<div class="clearfix"></div>
			</div>
			<?php
		} else {
			?>
 			<div class="form-group">
				<table class="table table-striped table-bordered questionary-print-fix">
				    <thead>
                        <tr>
                            <th scope="col"></th>
                            <?php
                            foreach ($answers as $answer)
                            {
                                echo "<th scope='col' class='answer-heading'>" . $answer . "</th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row"><?php echo $question['frage']?></th>
                            <?php
                            foreach ($answers as $answer)
                            {
                                ?>
                                <td class="radio-column" data-title="<?php echo $answer; ?>">
                                    <input type="radio" name="q[<?php echo $nr; ?>]" value="<?php echo $answer ?>" >
                                </td>
                                <?php
                            }
                            ?>
                        </tr>
                    </tbody>
				</table>
 			</div>
		<?php
		}
	break;

	case "multi":
        if ($horizontal) { ?>
            <div class="form-group check-group" <?php if ($hide) echo " style='display: none;'"?>>
                <label for=""><?php echo $question['frage']?></label>
                <?php
                $i = 0;
                foreach ($answers as $answer)
                {
                    ?>
                    <div class="checkbox" style="width: 20%">
                        <label>
                            <input type="checkbox" name="q[<?php echo $nr; ?>][<?php echo $i++ ?>]" value="<?php echo $answer ?>"
                                <?php is_array($qu) && in_array($answer,$qu) ? 'checked' : '' ?>>
                            <?php echo $answer ?>
                        </label>
                    </div>
                <?php
                }
                ?>
                <div class="clearfix"></div>
            </div>
        <?php }else{
            ?>
            <div class="form-group check-group" <?php if ($hide) echo " style='display: none;'"?>>
                <label for=""><?php echo $question['frage']?></label>
                <?php
                $i = 0;
                foreach ($answers as $answer)
                {
                    ?>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="q[<?php echo $nr; ?>][<?php echo $i++ ?>]" value="<?php echo $answer ?>"
                                <?php is_array($qu) && in_array($answer,$qu) ? 'checked' : '' ?>>
                            <?php echo $answer ?>
                        </label>
                    </div>
                <?php
                }
                ?>
                <div class="clearfix"></div>
            </div>
		<?php
        }
	break;
}