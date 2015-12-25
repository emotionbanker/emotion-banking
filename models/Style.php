<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%styles}}".
 *
 * @property integer $s_id
 * @property string $s_b_id
 * @property integer $s_p_id
 * @property string $style
 */
class Style extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%styles}}';
    }

    public function getBank()
    {
        return $this->hasOne(Bank::className(), ['b_id' => 's_b_id']);
    }

    /* Getter for bank name */
    public function getBankName() {
        return $this->bank->bezeichnung;
    }

    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['p_id' => 's_p_id']);
    }

    /* Getter for group name */
    public function getGroupName() {
        return $this->group->bezeichnung;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['s_b_id'], 'required'],
            [['s_b_id'], 'string', 'max' => 6, 'min' => 3],
            [['s_p_id'], 'required'],
            [['s_p_id'], 'integer'],
            [['style'], 'required'],
            [['style'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            's_b_id' => 'Bank ID',
            's_p_id' => 'Benutzergruppen',
            'style' => 'Zugeordneter Style'
        ];
    }

}