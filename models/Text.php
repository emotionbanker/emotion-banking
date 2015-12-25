<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%texts}}".
 *
 * @property integer $t_id
 * @property string $name
 * @property string $text
 */
class Text extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%texts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            't_id' => 'T ID',
            'name' => 'Name',
            'text' => 'Text',
        ];
    }
}
