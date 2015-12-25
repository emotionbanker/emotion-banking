<?php

namespace app\controllers;

use app\models\Translation;
use Yii;
use app\models\Language;
use app\models\search\LanguageSearch;
use yii\base\ErrorException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * LanguageController implements the CRUD actions for Language model.
 */
class LanguageController extends Controller
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Language models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LanguageSearch();

        if (isset($_GET['pageSize'])) {
            Yii::$app->session->set('pageSize',(int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Language model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Language model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Language();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->l_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Language model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->l_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionImport()
    {
        $imported = 0;
        $dropped = 0;
        $postData = Yii::$app->request->post();
        $file = UploadedFile::getInstanceByName('filename');
        if ($file) {
            $lang = $postData['lang'];
            if($lang == ''){
                return $this->render('import', [
                    'error' => "Language is not specified",
                    'imported' => 0,
                    'dropped' => 0,
                ]);
            }
            $content = file($file->tempName);
            $lines = 0;
            try {
                foreach ($content  as $line) {
                    $lines++;
                    $transl = explode('@', $line);
                    $oTranslation = Translation::findOne(['t_l_id' => $lang, 't_fr_id' =>$transl[0]]);
                    if ($oTranslation) {
                        $oTranslation->t_l_id = $lang;
                        $oTranslation->antworten = $transl[2];
                        $oTranslation->frage = $transl[1];
                    } else {
                        $oTranslation = new Translation();
                        $oTranslation->t_fr_id = $transl[0];
                        $oTranslation->t_l_id = $lang;
                        $oTranslation->antworten = $transl[2];
                        $oTranslation->frage = $transl[1];
                    }

                    if($oTranslation->save()){
                        $imported++;
                    }else{
                        $dropped++;
                    };

                }
            }
            catch (ErrorException $e) {
                return $this->render('import', [
                    'warning' => "Invalid character was found at line ". $lines . ". Imported questions - " . $imported,
                    'imported' => $imported,
                    'dropped' => $dropped,
                ]);
            }
        }elseif(!empty($postData)){
            return $this->render('import', [
                'error' => "No file was selected to import",
                'imported' => $imported,
                'dropped' => $dropped,
            ]);
        }

        return $this->render('import', [
            'imported' => $imported,
            'dropped' => $dropped,
        ]);
    }

    /**
     * Deletes an existing Language model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Language model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Language the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Language::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}