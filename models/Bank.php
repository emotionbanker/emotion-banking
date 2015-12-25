<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%bank}}".
 *
 * @property string $b_id
 * @property string $bezeichnung
 * @property string $klasse
 */
class Bank extends \yii\db\ActiveRecord
{
	public static $lockData = null;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bank}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['b_id'], 'required'],
            [['b_id'], 'string', 'max' => 6, 'min' => 6],
            [['b_id'], 'unique'],
            [['bezeichnung', 'klasse'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'b_id' => 'B ID',
            'bezeichnung' => 'Bezeichnung',
            'klasse' => 'Klasse',
        ];
    }

	public function isLocked($groupID = false)
	{
		if ($groupID) {
			$id = $this->b_id . ':' . $groupID;
		} else {
			$id = $this->b_id;
		}
		$staticDir = Yii::getAlias(Yii::$app->params['staticDir']);

		if (! self::$lockData) {
			if (!file_exists($staticDir . "banklocks")) return false;
			self::$lockData = file($staticDir . "banklocks");
		}

		foreach (self::$lockData as $list)
		{
			if (trim(strtolower($id)) == trim(strtolower($list)))
				return true;
		}

		return false;
	}

	public function lockUnlock($groupID = false)
	{
		if ($groupID) {
			$id = $this->b_id . ':' . $groupID;
		} else {
			$id = $this->b_id;
		}
		$staticDir = Yii::getAlias(Yii::$app->params['staticDir']);
		$found = false;

		$n = array();

		if (file_exists($staticDir . "banklocks"))
		{
			$data = file($staticDir . "banklocks");

			foreach ($data as $list)
			{
				if (trim($id) != trim($list))
					$n[] = $list;
				else
					$found = true;
			}
		}

		if (!$found) {
			$n[] = $id;
		}

		$r = fopen($staticDir . "banklocks", "w");
		foreach ($n as $ni)
			if (trim($ni) != "") fwrite($r, trim($ni) . "\n");
		fclose($r);
		self::$lockData = null;
	}


	public static function applyAlias($bank, $header)
	{
        $aliases = Alias::findAll(['b_id' => $bank]);
		foreach ($aliases as $alias) {
			$header = str_replace($alias->original, $alias->alias, $header);
		}
		return $header;
	}

}
