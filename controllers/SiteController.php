<?php

namespace app\controllers;

use app\models\AnketForm;
use app\models\Bank;
use app\models\Code;
use app\models\Form;
use app\models\Language;
use app\models\Meta;
use app\models\UserText;
use Yii;
use yii\base\ErrorException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Settings;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionIndex()
    {
        $error = '';
        $model = new AnketForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($code = $model->validateCode()) {
                if ($model->processCode($code)) {
                    $this->redirect(['/site/welcome']);
                } else {
                    $this->redirect(['/site/index']);
                }
            } else {
                $error = $model->getLastErrorMessage();
            }
        }

        return $this->render('index',[
            'model' => $model,
            'error' => $error
        ]);
    }

    public function actionWelcome()
    {
        $is_locked = Settings::getSetting('locked');
        if($is_locked == 1){
            return $this->render('error',[
                'name' => 'Fehler',
                'message' => 'Das System ist gesperrt. Bei Fragen wenden sie sich bitte an Emotion Banking.'
            ]);
        }

        if (!isset(Yii::$app->session['anketData'])) {
            $this->redirect(['/site/index']);
        }

        $data = Yii::$app->session['anketData'];

        $text = UserText::getText($data['group']['p_id'], $data['bank']['b_id'], $data['lang'], true);

        if(is_null($text)){
            return $this->render('error',[
                'name' => 'Fehler',
                'message' => 'kein Starttext für diese Sprache gefunden'
            ]);
        }

        return $this->render('welcome',[
            'text' => $text,
            'code' => $data["original"],
			'style' => $data["style"]
        ]);
    }

    public function actionQuestionnaire($bezeichnung, $groupId, $langId){
        $is_locked = Settings::getSetting('locked');
        if($is_locked == 1){
            return $this->render('error',[
                'name' => 'Fehler',
                'message' => 'Das System ist gesperrt. Bei Fragen wenden sie sich bitte an Emotion Banking.'
            ]);
        }
        try{
            $bankKlasse = Bank::findOne(['b_id' => $bezeichnung])->klasse;
            $questionnaire = Form::findOne(['f_klasse' => $bankKlasse, 'f_p_id' => $groupId]);
            if(empty($questionnaire)){
                throw(new ErrorException('Es gibt keinen Fragebogen für ihre Banken-, bzw. Kundengruppenauswahl'));
            }
            $code = $questionnaire->createSpecificCode($bezeichnung);

            if($code->hasErrors()){
                return $this->render('error',[
                    'name' => 'Fehler',
                    'message' => $code->getLastErrorMessage()
                ]);
            }
        }
        catch(ErrorException $e){
            return $this->render('error',[
                'name' => 'Fehler',
                'message' => $e->getMessage()
            ]);
        }

        $codeString = $code->__toString();

        if($codeString !== null){
            $warning = '';
            $model = new AnketForm();
            $model->code = $codeString;
            $model->language = $langId;
            if($langId != "default"){
                $lanuage = Language::findOne($langId);
                if(empty($lanuage)){
                    $warning = "Die angegebene Sprache ". $langId ." kann nicht gefunden werden. Es wird die Standardsprache angezeigt";
                }
            }
            if ($code !== false && $code = $model->validateCode()) {
                $model->processCode($code);

                $data = Yii::$app->session['anketData'];

                $text = UserText::getText($data['group']['p_id'], $data['bank']['b_id'], $data['lang'], true);

                if(is_null($text)){
                    return $this->render('error',[
                        'name' => 'Fehler',
                        'message' => 'kein Starttext für diese Sprache gefunden'
                    ]);
                }

                return $this->render('welcome',[
                    'text' => $text,
                    'code' => $data["original"],
                    'warning' => $warning,
                    'style' => $data['style']
                ]);
            } else {
                return $this->render('error',[
                    'name' => 'Fehler',
                    'message' => 'Bank gesperrt, Code ungültig oder bereits verwendet. Anmeldung fehlgeschlagen'
                ]);
            }
        }else{
            $this->redirect(['/site/index']);
        }

        $data = Yii::$app->session['anketData'];

        $form = Form::findOne($data['form']);

        $questions = $form->getQuestions($bank_id = $data["bank"]["b_id"]);

        //default
        $status = 0;

        //code not needed.
        if (Yii::$app->request->post('q')) {
            $userAnswers = Yii::$app->request->post('q');

            $status = $form->saveAnswers($data['code'], $userAnswers);

            $data['status'] = $status;
            $data['code']['status'] = $status;
        }else{
            $data = Yii::$app->session['anketData'];
            $text = UserText::getText($data['group']['p_id'], $data['bank']['b_id'], $data['lang'], true);

            if(is_null($text)){
                return $this->render('error',[
                    'name' => 'Fehler',
                    'message' => 'kein Starttext für diese Sprache gefunden'
                ]);
            }
            return $this->render('welcome',[
                'text' => $text,
                'code' => $data["original"],
				'style' => $data["style"]
            ]);
        }

        Yii::$app->session['anketData'] = $data;

        if (! ($status < $form->getQuestionsCount($questions) )) {
            $this->redirect(['/site/end']);
        }

        return $this->render('form',[
            'status' => $status,
            'percent' => round(($status / $form->getQuestionsCount($questions)) * 100),
            'questions' => $questions,
            'anket' => $form,
            'bank' => $data['bank']['b_id'],
            'style' => $data['style']
        ]);
    }

    public function actionForm()
    {
        if (! isset(Yii::$app->session['anketData'])) {
            $this->redirect(['/site/index']);
        }

        $data = Yii::$app->session['anketData'];

        $form = Form::findOne($data['form']);
        $questions = $form->getQuestions($bank_id = $data["bank"]["b_id"]);

        $status = isset($data['status']) && !empty($data['status']) ? $data['status'] : Code::findOne($data['code']['z_id'])->status;

        if (Yii::$app->request->post('q')) {
            $userAnswers = Yii::$app->request->post('q');

            $status = $form->saveAnswers($data['code'], $userAnswers);

            $data['status'] = $status;
            $data['code']['status'] = $status;

            $code = Code::findOne($data['code']['z_id']);
            $code->used = 0;
            //workaround
            $code->count = 1;
            $code->status = $status;
            $code->save();
        }

        Yii::$app->session['anketData'] = $data;

        if (! ($status < $form->getQuestionsCount($questions) )) {
            $code = Code::findOne($data['code']['z_id']);
            $code->used = 1;

            $meta = Meta::findOne($data['code']['z_id']);
            $meta->time_end = time();
            $meta->save();

            //workaround. Doesn't affect nothing at all
            $code->count = 1;

            $code->save();
            $this->redirect(['/site/end']);
        }

        return $this->render('form',[
            'status' => $status,
            'percent' => round(($status / $form->getQuestionsCount($questions)) * 100),
            'questions' => $questions,
            'anket' => $form,
            'bank' => $data['bank']['b_id'],
            'style' => $data['style']
        ]);
    }

    public function actionEnd()
    {
        if (! isset(Yii::$app->session['anketData'])) {
            $this->redirect(['/site/index']);
        }

        $data = Yii::$app->session['anketData'];

        Yii::$app->session->remove('anketData');

        $text = UserText::getText($data['group']['p_id'], $data['bank']['b_id'], $data['lang'], false);

        if(is_null($text)){
            return $this->render('error',[
                'name' => 'Fehler',
                'message' => 'kein Endtext für diese Sprache gefunden'
            ]);
        }

        return $this->render('end',[
            'text' => $text,
            'style' => $data['style']
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['/admin']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/admin']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
