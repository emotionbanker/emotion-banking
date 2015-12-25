<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%qalias}}".
 *
 * @property integer $a_fr_id
 * @property integer $al_id
 * @property string $alias
 */
class QuestionAlias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%qalias}}';
    }

	public static function primaryKey()
	{
		return [];
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['a_fr_id', 'al_id'], 'required'],
            [['a_fr_id', 'al_id'], 'integer'],
            [['alias'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'a_fr_id' => '',
            'al_id' => 'Alias- Nummer',
            'alias' => 'Alias',
        ];
    }
}
