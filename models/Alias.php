<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "victor2014alias".
 *
 * @property integer $a_id
 * @property string $b_id
 * @property string $original
 * @property string $alias
 */
class Alias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%alias}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['original', 'alias'], 'string'],
            [['b_id'], 'string', 'max' => 6]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'a_id' => 'A ID',
            'b_id' => 'B ID',
            'original' => 'Original',
            'alias' => 'Alias',
        ];
    }
}
