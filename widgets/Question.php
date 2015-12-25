<?php

namespace app\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Question extends \yii\base\Widget {

	public $multi = false;
	public $type = null;
	public $preview = true;

	public $questions = [];
	public $num;
	public $qu;
	public $translate = false;
	public $showConditions = false;

	public function run()
	{
		if (!$this->multi) {
			echo $this->render('question',[
				'questions' => $this->questions,
				'num' => $this->num,
				'qu' => $this->qu,
				'translate' => $this->translate,
				'showConditions' => $this->showConditions,
				'preview' => $this->preview
			]);
		} else {
			echo $this->render('questionMulti',[
				'questions' => $this->questions,
				'num' => $this->num,
				'qu' => $this->qu,
				'translate' => $this->translate,
				'showConditions' => $this->showConditions,
				'preview' => $this->preview
			]);
		}
	}
}

function echoMultiQuestion($questions,$num,$qu,$trans=true,$showcond=false)
{
	for ($i = 0; $i < count($questions); $i++) {
		if ($trans) $questions[$i] = translateQ($questions[$i]);
	}

	$num += 1; //bei 1 beginnen, nicht bei 0
	$nr = $num - count($questions);

	$answers = explode(";", $questions[0][2]);
	if (!is_array($answers))
		$answers = array($questions[0][2]);

	foreach($answers as $key => $value)	{
		$answers[$key] = trim($value);
	}

	// header

	$style="light";

	echo "<tr><td class='head'><table class='answer'>";

	if ($questions[0][1] != "text")
	{

		echo "<tr class='".$style."'><td></td>";

		foreach ($answers as $answer)
		{
			echo "<td class='head'><small>" . $answer . "</small></td>";
		}
	}

	echo "</tr>";

	foreach($questions as $q)
	{
		$q = applyAlias($q);

		echo "<tr class='".$style."' ";
		echo ">";

		$nr = $q['pos'];

		if ($showcond) $q[0] = "<small><b>" . $q[3] . "</b></small> " . $q[0];

		if ($showcond && $q['condition'])
		{

			$q[0] = "<span style='background-color: lightgreen;'> wenn ".$q['condition']."</span> " . $q[0];
		}



		echo "<td class='qleft".$style."' $cs>";
		if ($_SESSION['numbers'] == 1) echo $q[3] . " - ";

		echo filterQText($q[0])."</td>";

		echo "<input type='hidden' name='q[".$nr."]' value=''/>";

		switch($q[1])
		{
			case "text":
				echo "<td class='input'><input type='text' name='q[".$nr."]' size='90'/></td>";
				break;

			case "radio":
				$ai = 1;
				foreach ($answers as $answer)
				{
					$elementId = "q-" . $nr . "-" . $ai;
					echo "<td class='input' onclick='document.getElementById(\"".$elementId."\").checked = true;'><input type='radio' id='".$elementId."' name='q[".$nr."]' value='".$answer."' ";

					echo "/></input></td>";
					$ai++;
				}
				break;

			case "multi":
				$i = 0;
				foreach ($answers as $answer)
				{
					echo "<td class='input'><input type='checkbox' name='q[".$nr."][".$i++."]' value='".$answer."' ";
					if (is_array($qu[$nr]) && in_array($answer,$qu[$nr]))
						echo "checked ";
					echo "/></input></td>";
				}
				break;

			case "multitext":
				$in = 1;
				foreach ($answers as $answer)
				{
					echo "<tr><td class='pad'>";
					echo $in . ". <input type='text' name='q[".$nr."][".$i++."]' value='".$qu."' size='90'>";
					echo "</td></tr>";
					$in++;
				}

				break;
		}

		echo "</tr>";
		if ($style == "light") $style = "dark";
		else $style = "light";
		$nr++;
	}

	echo "</table></td></tr>";
}

function echoQuestion($q,$nr,$qu,$trans=true,$showcond=false)
{
	$hide = $q['hidden'];
	$aslist = $q['aslist'];

	if ($trans) $q = translateQ($q);

	$q = applyAlias($q);

	$nr += 1;

	$answers = explode(";", $q[2]);
	if (!is_array($answers))
		$answers = array($q[2]);

	foreach($answers as $key => $value)
	{
		$answers[$key] = trim($value);
	}

	$nr = $q['pos'];

	if ($showcond) $q[0] = $q[3] . " - " . $q[0];

	if ($showcond && $q['condition'])
	{
		$q[0] = "<span style='background-color: lightgreen;'> wenn ".$q['condition']."</span> " . $q[0];
	}

	echo "<input type='hidden' name='q[".$nr."]' value=''/>";
	switch($q[1])
	{
		case "text":
			echo "<tr><td class='head'>";
			if ($_SESSION['numbers'] == 1) echo $q[3] . " - ";
			echo filterQText($q[0])."</td></tr>";
			echo "<tr><td class='pad'><input type='text' name='q[".$nr."]' value='".$qu."' size='90'></td></tr>";
			break;

		case "multitext":
			echo "<tr><td class='head'>" ;
			if ($_SESSION['numbers'] == 1) echo $q[3] . " - ";
			echo filterQText($q[0])."</td></tr>";
			$in = 1;
			$i = 0;
			foreach ($answers as $answer)
			{
				echo "<tr><td class='pad'>";
				echo $in . ". <input type='text' name='q[".$nr."][".$i++."]' value='".$qu."' size='90'>";
				echo "</td></tr>";
				$in++;
			}

			break;

		case "radio":
			if ($aslist)
			{
				$style="light";
				$i = 0;
				echo "<tr><td>";

				if ($_SESSION['numbers'] == 1) echo $q[3] . " - ";
				echo filterQText($q[0]) . "<br/>";
				$break = 0;
				echo "<table>";
				foreach ($answers as $answer)
				{
					echo "<tr class='$style'>";
					echo "<td class='input'>";
					echo "<input type='radio' name='q[".$nr."]' value='".$answer."' ";
					echo "/>".$answer."</input>";
					echo "</td>";
					if ($style == "light") $style = "dark";
					else $style = "light";
					echo "</tr>";
				}
				echo "</table>";
				echo "</td></tr>";
			}
			else if (count($answers) > RADIO_LIMIT)
			{
				$style="light";
				echo "<tr><td><br/>";
				echo "<table";
				if ($hide) echo " style='display: none;'";
				echo ">";
				echo "<tr class='$style'>";

				echo "<td class='input'>";
				if ($_SESSION['numbers'] == 1) echo $q[3] . " - ";
				echo filterQText($q[0]) . "";

				echo "</td><td class='input'><select name='q[".$nr."]'>";
				echo "<option value='' selected>---</option>";
				$ai = 1;
				foreach ($answers as $answer)
				{
					echo "<option value'".$answer."' ";
					//preselect
					//if ($q['dset'] == $ai) echo " selected";
					echo ">$answer</option>";
					$ai++;
				}
				echo "</select>";
				echo "</td>";
				echo "</tr>";
				echo "</table>";
				echo "</td></tr>";
			}
			else if (count($answers) > RADIO_MULTILINE_LIMIT)
			{
				$style="light";
				$i = 0;
				echo "<td>";

				if ($_SESSION['numbers'] == 1) echo $q[3] . " - ";
				if ($hide && ($_SESSION['numbers'] == 1)) echo "HIDDEN";
				if (!$hide || ($_SESSION['numbers'] == 1)) echo filterQText($q[0]) . "<br/>";

				$break = 0;
				echo "<table ";
				if ($hide && ($_SESSION['numbers'] != 1)) echo " style='display: none;'";
				echo ">";

				echo "<tr class='$style'>";
				foreach ($answers as $answer)
				{
					echo "<td class='input'>";
					echo "<input type='radio' name='q[".$nr."]' value='".$answer."' ";
					echo "/>".$answer."</input>";
					echo "</td>";
					if ($break++ == (RADIO_MULTILINE_ROWS-1))
					{
						$break = 0;
						//echo "<br/>";
						if ($style == "light") $style = "dark";
						else $style = "light";
						echo "</tr><tr class='$style'>";
					}

				}

				echo "</tr>";
				echo "</table>";
				echo "</td>";
			}
			else
			{
				$style="light";
				$i = 0;
				echo "<td><table class='answer'";
				if ($hide) echo " style='display: none;'";
				echo ">";
				echo "<tr class='".$style."'><td></td>";

				foreach ($answers as $answer)
				{
					echo "<td class='head'><small>" . $answer . "</small></td>";
				}

				echo "</tr>";
				echo "<tr>";
				echo "<td class='qleft".$style."'>";
				if ($_SESSION['numbers'] == 1) echo $q[3] . " - ";
				echo filterQText($q[0])."</td>";

				$ai = 1;
				foreach ($answers as $answer)
				{
					echo "<td class='input'><input type='radio' name='q[".$nr."]' value='".$answer."' ";
					echo "/></input></td>";
					$ai++;
				}

				echo "</tr>";
				echo "</table></td></tr>";
			}
			break;

		case "multi":
			$style="light";
			$i = 0;
			echo "<td>";

			if ($_SESSION['numbers'] == 1) echo $q[3] . " - ";
			echo filterQText($q[0]) . "<br/>";
			$break = 0;
			echo "<table>";
			echo "<tr class='$style'>";
			foreach ($answers as $answer)
			{
				echo "<td class='input'>";
				echo "<input type='checkbox' name='q[".$nr."][".$i++."]' value='".$answer."' ";
				if (is_array($qu) && in_array($answer,$qu))
					echo "checked ";
				echo "/>".$answer."</input>";
				echo "</td>";
				if ($break++ == 1)
				{
					$break = 0;
					//echo "<br/>";
					if ($style == "light") $style = "dark";
					else $style = "light";
					echo "</tr><tr class='$style'>";
				}

			}

			echo "</tr>";
			echo "</table>";
			echo "</td>";
			break;
	}
}