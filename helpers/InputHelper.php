<?php
namespace app\helpers;

use yii\helpers\ArrayHelper;

class InputHelper
{
	public static function getDropdownOptions($class, $id, $name, $pleaseSelect = false, $allOption = false, $allDefautl=false)
	{
		$options = $class::find()->orderBy($name)->all();
		$options = ArrayHelper::map($options, $id, $name);

		if ($allOption) {
			if ($allDefautl) {
				$options = [ 0=>'Default' ] + $options;
			} else {
				$options = [ 0=>'Alle' ] + $options;
			}

		}

		if ($pleaseSelect) {
			$options = [ ''=>'Bitte wählen Sie' ] + $options;
		}
		return $options;
	}
}