<?php

namespace app\models;

use Yii;
use yii\db\Transaction;

/**
 * This is the model class for table "{{%personen}}".
 *
 * @property integer $p_id
 * @property string $bezeichnung
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%personen}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bezeichnung'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'p_id' => 'P ID',
            'bezeichnung' => 'Bezeichnung',
        ];
    }
}
