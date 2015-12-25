<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%settings}}".
 *
 * @property integer $pm_id
 * @property string $pm_name
 * @property string $pm_value
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    public function  __get($key){
        $settingModel = $this->findOne(['pm_id' => $key]);
        if($settingModel){
            return $settingModel->getAttribute('pm_value');
        }else{
            return null;
        }
    }

    public function  __set($key, $val){
        $settingModel = $this->findOne(['pm_id' => $key]);
        if($settingModel){
            $this->setAttribute('pm_value', $val);
        }else{
            throw new \ErrorException("Cannot set protected attribute ".$key);
        }
    }

    public function populate($postObj){
        if($this->load($postObj)){
            $data = $postObj['Settings'];
            foreach($data as $key=>$val){
                $this[$key] = $val;
            }
            return true;
        }else{
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pm_id'], 'string', 'max' => 6],
            [['pm_name'], 'string', 'max' => 255],
            [['pm_value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pm_id' => 'Parameter ID',
            'pm_name' => 'Parameter Name',
            'pm_value' => 'Parameter Value',
        ];
    }

    public static function getSetting($setting_id){
        $setting = Settings::findOne(['pm_id' => $setting_id]);
        if($setting){
            return $setting->$setting_id;
        }else{
            return false;
        }
    }
}
