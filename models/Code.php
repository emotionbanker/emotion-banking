<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%zugangsdaten}}".
 *
 * @property integer $z_id
 * @property string $code
 * @property string $z_b_id
 * @property integer $z_p_id
 * @property integer $used
 * @property integer $status
 */
class Code extends \yii\db\ActiveRecord
{

	public $count;
    /**
     * @inheritdoc
     */
	public static $_codes = null;

    public function getMeta()
    {
        return $this->hasOne(Meta::className(), ['m_z_id' => 'z_id']);
    }

    public function getFillingDate()
    {
        if(!is_null($this->meta)){
            return date("Y-m-d H:i:s", $this->meta->time_start);
        }else{
            return '—';
        }
    }

    public function getDuration()
    {
        if(!is_null($this->meta)){
            if(!is_null($this->meta->time_end)){
                return date("d H:i:s", $this->meta->time_end - $this->meta->time_start);
            }else{
                return '—';
            }
        }else{
            return '—';
        }
    }

    public static function tableName()
    {
        return '{{%zugangsdaten}}';
    }

	public static function generateCode()
	{
		if (! self::$_codes) {
			self::$_codes = ArrayHelper::getColumn(self::find()->select('code')->all(), 'code');
		}

		$chars = array(1, 2, 3, 4, 5, 6, 7, 8, 9,
			'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' );

		$code ='';

		$generated = false;

		while (! $generated) {
			for ($j = 0; $j < 4; $j++) {
				$r = rand(0, count($chars)-1);
				$code .= $chars[$r];
			}

			if (!in_array($code, self::$_codes)) {
				$generated = true;
			} else {
				$code ='';
			}
		}
		return $code;
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['z_p_id', 'used', 'status'], 'integer'],
            [['z_b_id'], 'string', 'max' => 6],
            [['z_b_id', 'z_p_id'], 'required'],
            [['z_b_id'], 'notEmpty'],
            [['z_b_id'], 'bankNotLocked'],
            [['z_p_id'], 'notEmpty'],
            [['z_p_id'], 'groupNotLocked'],
            [['count'], 'required'],
            [['count'], 'unsigned']
        ];
    }

    public function notEmpty($attribute){
        if (empty($this->$attribute) || $this->$attribute == '') {
            $this->addError($attribute, "Parameter " . $attribute . " darf nicht leer sein");
        }
    }

    public function unsigned($attribute){
        if (empty($this->$attribute) || (is_int($this->$attribute) && $this->$attribute <= 0)) {
            $this->addError($attribute, "Parameter " . $attribute . " darf positive ganze Zahlen sein");
        }
    }

    public function bankNotLocked($attribute){
        $bank = Bank::findOne($this->$attribute);
        if($bank->isLocked()){
            $this->addError($attribute, "Code ist ungültig. Das Bank ist gesperrt.");
            return false;
        }
        return true;
    }

    public function groupNotLocked($attribute){
        $bank = Bank::findOne($this->z_b_id);
        if($bank->isLocked($this->$attribute)){
            $this->addError($attribute, "Code ist ungültig. Die Gruppe ist für die ausgewählte Bank gesperrt.");
            return false;
        }
        return true;
    }

    public function __toString(){
        return $this->z_b_id . str_pad($this->z_p_id, 3, '0', STR_PAD_LEFT) . $this->code;
    }

    public function getLastErrorMessage(){
        $errors = $this->errors;
        foreach($errors as $error){
            return $error[0];
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'z_id' => 'Z ID',
            'code' => 'Code',
            'z_b_id' => 'Bank',
            'z_p_id' => 'Benutzergruppe',
            'used' => 'Used',
            'status' => 'Status',
			'count' => 'Anzahl der codes'
        ];
    }
}
