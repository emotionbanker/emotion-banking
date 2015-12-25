<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "{{%meta}}".
 *
 */
class AnketForm extends Base
{

    public $code;
    public $language;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'language'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        ];
    }

    public function validateCode()
    {
        $code = substr($this->code, -4, 4);
        $bank = substr($this->code, 0, strlen($this->code)-7);

        $code = Code::findOne(['z_b_id' => $bank, 'code' => $code]);

        $original = $this->code;

        if (!$code) {
            $this->addError('z_b_id', 'Bank gesperrt, Code ungültig oder bereits verwendet. Anmeldung fehlgeschlagen');
            return false;
        } else {
            if(!$code->groupNotLocked('z_p_id') || !$code->bankNotLocked('z_b_id')){
                $errors = $code->getFirstErrors();
                foreach($errors as $error=>$attribute){
                    $this->addError($attribute, $error);
                }
                return false;
            }else{
                return array('code' => $code, 'original' => $original);
            }
        }

    }

    public function isCodeLocked($bank, $group)
    {
        $staticDir = Yii::$app->params['staticDir'];

        if (!file_exists($staticDir . "banklocks")) return false;

        $data = file($staticDir . "banklocks");

        foreach ($data as $list) {
            if (
                (trim(strtolower($bank)) == trim(strtolower($list)))
                ||
                (trim(strtolower($bank. ':' . $group)) == trim(strtolower($list)))
            ) {
                return true;
            }
        }

        return false;
    }

    public function isCodeActive($code)
    {
        if ($code->used) {
            return false;
        }

        if ($this->isCodeLocked($code->z_b_id, $code->z_p_id)) {
            return false;
        }

        return true;
    }

    public function processCode($fullCode)
    {
        $code = $fullCode['code'];
        $original = $fullCode['original'];
        if ($this->isCodeActive($code)) {
            $group = Group::findOne($code->z_p_id)->toArray();
            $bank  = Bank::findOne($code->z_b_id)->toArray();
            $form = Form::findOne(['f_klasse' => $bank['klasse'], 'f_p_id' => $group['p_id']]);
            $style = Style::findOne(['s_b_id' => $bank['b_id'], 's_p_id' => $group['p_id']]);
            if(!$style){
                $style = Settings::getSetting('style');
            }else{
                $style = $style->style;
            }

            $label = Yii::$app->params['default_next_label'];
            $message = Yii::$app->params['default_next_message'];


			if($this->language != "default")
			{
				$language = Language::findOne($this->language);
				
				if($language != null){
					if($language->label != ''){
						$label = $language->label;
					}

					if($language->message != ''){
						$message = $language->message;
					}
				}

		    }

            Yii::$app->session['anketData'] = [
                'original' => $original,
                'code' => $code->toArray(),
                'group' => $group,
                'bank' => $bank,
                'form' => $form->f_id,
                'status' => 0,
                'lang' => $this->language,
                'style' => $style,
                'label' => $label,
                'message' => $message
            ];

            $meta = Meta::findOne(['m_z_id' => $code->z_id]);

            if (!$meta) {
                $meta = new Meta();
                $meta->m_z_id = $code->z_id;
                $meta->ip = $_SERVER['REMOTE_ADDR'];
                $meta->time_start = time();
            } else {
                $meta->ip = $_SERVER['REMOTE_ADDR'];
            }

            $meta->save();
            return true;
        }
        return false;
    }
}