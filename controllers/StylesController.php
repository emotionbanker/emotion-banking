<?php

namespace app\controllers;

use app\models\search\StylesSearch;
use app\models\Style;
use app\models\Settings;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * StyleController implements the CRUD actions for Style model.
 */
class StylesController extends Controller
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
     * Lists all Style models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (isset($_GET['pageSize'])) {
            Yii::$app->session->set('pageSize',(int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $searchModel = new StylesSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $defStyle = Settings::getSetting('style');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'defaultStyle' => $defStyle
        ]);
    }

    /**
     * Displays a single Style model.
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
     * Creates a new Style model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Style();
        $styles = $this->getAvailableStyles();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'styles' => $styles
            ]);
        }
    }

    /**
     * Updates an existing Style model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $styles = $this->getAvailableStyles();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/styles/index/']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'styles' => $styles,
            ]);
        }
    }

    /**
     * Deletes an existing Style model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['/styles/index/']);
    }

    public function actionDefault(){
        $setting = Settings::findOne(['pm_id' => 'style']);
        $styles = $this->getAvailableStyles();

        if ($setting->populate(Yii::$app->request->post()) && $setting->save()) {
            return $this->redirect(['/styles/index/']);
        } else {
            return $this->render('default', [
                'model' => $setting,
                'styles' => $styles
            ]);
        }
    }

    /**
     * Finds the Style model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Style the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Style::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function getAvailableStyles(){
        $stylesPath = Yii::getAlias('@webroot');
        $styles = array_diff(scandir($stylesPath.'/css/styles/'), array('..', '.'));
        return array_combine($styles, $styles);
    }
}
