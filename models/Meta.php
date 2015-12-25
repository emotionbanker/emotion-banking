<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%meta}}".
 *
 * @property integer $m_z_id
 * @property string $ip
 * @property integer $time_start
 * @property integer $time_end
 */
class Meta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%meta}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['m_z_id'], 'required'],
            [['m_z_id', 'time_start', 'time_end'], 'integer'],
            [['ip'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'm_z_id' => 'M Z ID',
            'ip' => 'Ip',
            'time_start' => 'Time Start',
            'time_end' => 'Time End',
        ];
    }
}
