<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%usertext}}".
 *
 * @property integer $ut_id
 * @property integer $p_id
 * @property string $b_id
 * @property integer $l_id
 * @property integer $t_id
 * @property integer $isStart
 * @property integer $isEnd
 */
class UserText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%usertext}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['b_id'], 'bankValidation'],
            [['p_id'], 'benutzerValidation'],
            [['l_id', 't_id', 'isStart', 'isEnd'], 'integer'],
            [['b_id','p_id','l_id', 't_id'], 'required'],
        ];
    }

    public function benutzerValidation($attribute, $params){
        if (!isset($this->$attribute)) {
            $this->addError($attribute, "Benutzer darf nicht leer sein");
        }
    }

    public function bankValidation($attribute, $params){
        if (!isset($this->$attribute)) {
            $this->addError($attribute, "Bank darf nicht leer sein");
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'ut_id' => 'Ut ID',
            'p_id' => 'Benutzer',
            'b_id' => 'Bank',
            'l_id' => 'Sprache',
            't_id' => 'Begrüssungstext',
            'isStart' => 'Is Start',
            'isEnd' => 'Is End',
        ];
        if($this->isEnd){
            $labels['t_id'] = 'Schlusstext';
        }
        return $labels;
    }

    public static function getText($user = null, $bank = null, $language = null, $isStart = true) {
        $query = UserText::find()
            ->where(['p_id' => $user, 'b_id' => $bank, 'l_id' => $language == 'default' || $language === null ? '0' : $language])
            ->orWhere(['p_id' => 0, 'b_id' => 0, 'l_id' => $language == 'default' || $language === null ? '0' : $language]);
            if(!$isStart) {
                $query->andWhere(['isEnd' => 1]);
            } else {
                $query->andWhere(['isStart' => 1]);
            }
        $query->orderBy(['p_id' => SORT_DESC, 'b_id' => SORT_DESC, 'l_id' =>SORT_DESC  ]);

        $text = $query->one();

        return $text;
    }

    public function exists(){
        return isset($this->ut_id);
    }
}
