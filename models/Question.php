<?php

namespace app\models;

use Yii;
use yii\db\Transaction;

/**
 * This is the model class for table "{{%frage}}".
 *
 * @property integer $fr_id
 * @property string $frage
 * @property string $display
 * @property string $antworten
 * @property string $suche
 */
class Question extends \yii\db\ActiveRecord
{

	public static $types = [
        'radio' => 'auswahl (radio buttons)',
		'text' => 'freie antwort (textfeld)',
        'multitext' => 'mehrere freie antworten (textfelder)',
  		'multi' => 'mehrfachauswahl (tickboxes)'
	];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%frage}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['frage', 'antworten', 'suche'], 'string'],
            [['display'], 'string', 'max' => 10],
			[['frage'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fr_id' => 'ID',
            'frage' => 'Frage/Text',
            'display' => 'Art',
            'antworten' => 'Antworten',
            'suche' => 'Suchkürzel',
        ];
    }

	public function getAliasesCount()
	{
		return QuestionAlias::find()->where(['a_fr_id'=>$this->fr_id])->count();
	}

    public static function translateQuestion(& $question, $lang) {
        if (isset($question['fr_id'])) {
            $translation = Translation::findOne(['t_l_id' => $lang, 't_fr_id'=>$question['fr_id']]);
            if ($translation) {
                $question['frage'] = $translation->frage;
                $question['antworten'] = $translation->antworten;
            }
        }

    }
}
