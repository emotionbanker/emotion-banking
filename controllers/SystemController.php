<?php

namespace app\controllers;

use app\models\Alias;
use app\models\Bank;
use app\models\Code;
use app\models\Form;
use app\models\Group;
use app\models\Language;
use app\models\Meta;
use app\models\Question;
use app\models\QuestionAlias;
use app\models\Result;
use app\models\Style;
use app\models\Text;
use app\models\Translation;
use app\models\UserText;
use app\models\Settings;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\ContactForm;

class SystemController extends Controller
{
	public $layout = 'admin';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionStatistic()
    {
        return $this->render('index');
    }

    public function actionLock()
    {
        $is_locked = Settings::getSetting('locked');
        $setting = Settings::findOne(['pm_id' => 'locked']);
        $setting->locked = $is_locked == 1 ? 0 : 1;
        if(true == $setting->save()){
            Yii::$app->user->logout();
            return $this->redirect(['/admin']);
        }else{
            return $this->redirect(['index']);
        }
    }

    public function actionReset()
    {
        $db = Yii::$app->db;
        $db->createCommand('TRUNCATE {{%bank}}')->execute();
        $db->createCommand('TRUNCATE {{%frage}}')->execute();
        $db->createCommand('TRUNCATE {{%alias}}')->execute();
        $db->createCommand('TRUNCATE {{%meta}}')->execute();
        $db->createCommand('TRUNCATE {{%fragebogen}}')->execute();
        $db->createCommand('TRUNCATE {{%personen}}')->execute();
        $db->createCommand('TRUNCATE {{%languages}}')->execute();
        $db->createCommand('TRUNCATE {{%qalias}}')->execute();
        $db->createCommand('TRUNCATE {{%styles}}')->execute();
        $db->createCommand('TRUNCATE {{%texts}}')->execute();
        $db->createCommand('TRUNCATE {{%translations}}')->execute();
        $db->createCommand('TRUNCATE {{%usertext}}')->execute();
        $db->createCommand('TRUNCATE {{%ergebnisse}}')->execute();
        return $this->redirect(['/admin']);
    }

    public function actionClean()
    {
        Code::updateAll(['used' => 0, 'status' => 0]);
        Meta::deleteAll();
        Result::deleteAll();
        return $this->redirect(['/system/statistic']);
    }
}
