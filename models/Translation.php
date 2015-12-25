<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%translations}}".
 *
 * @property integer $s_l_id
 * @property integer $t_fr_id
 * @property string $frage
 * @property string $antworten
 */
class Translation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%translations}}';
    }

    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['fr_id' => 't_fr_id']);
    }

    /* Getter for question name */
    public function getQuestionOriginal() {
        return $this->question->frage;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['t_l_id', 't_fr_id'], 'required'],
            [['t_l_id', 't_fr_id'], 'integer'],
            [['frage', 'antworten'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            't_l_id' => 'Language ID',
            't_fr_id' => 'Frage ID',
            'frage' => 'Frage',
            'antworten' => 'Antworten'
            //'frageOriginal' => Yii::t('app', 'Original Frage')
        ];
    }
}
