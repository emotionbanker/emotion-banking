<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%ergebnisse}}".
 *
 * @property integer $e_id
 * @property integer $e_z_id
 * @property integer $e_fr_id
 * @property string $antwort
 * @property integer $a_id
 */
class Result extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ergebnisse}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['e_z_id', 'e_fr_id'], 'required'],
            [['e_z_id', 'e_fr_id', 'a_id'], 'integer'],
            [['antwort'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'e_id' => 'E ID',
            'e_z_id' => 'E Z ID',
            'e_fr_id' => 'E Fr ID',
            'antwort' => 'Antwort',
            'a_id' => 'A ID',
        ];
    }
}
