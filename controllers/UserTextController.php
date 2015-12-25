<?php

namespace app\controllers;

use Yii;
use app\models\UserText;
use app\models\search\UserTextSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserTextController implements the CRUD actions for UserText model.
 */
class UserTextController extends Controller
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
     * Lists all UserText models.
     * @return mixed
     */
    public function actionIndex($type)
    {
		switch ($type) {

			case 'start':
				$isStart = true;
				$isEnd = false;
				break;

			case 'end':
				$isStart = false;
				$isEnd = true;
				break;
		}


        if (isset($_GET['pageSize'])) {
            Yii::$app->session->set('pageSize',(int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $searchModel = new UserTextSearch($isStart, $isEnd);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'type' => $type
        ]);
    }

    /**
     * Displays a single UserText model.
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
     * Creates a new UserText model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type)
    {
        $model = new UserText();
		switch ($type) {
			case 'start':
				$model->isStart = true;
                $model->isEnd = false;
				break;

			case 'end':
                $model->isStart = false;
                $model->isEnd = true;
				break;
		}
        $post = Yii::$app->request->post();

        if(!empty($post)){
            if(!($model->load($post) && $model->validate())){
                return $this->render('create', [
                    'model' => $model,
                    'type' => $type
                ]);
            }

            $models = [];
            $postData = Yii::$app->request->post()['UserText'];
            $groups = $postData['p_id'];
            $banks = $postData['b_id'];
            $l_id = $postData['l_id'];
            $t_id = $postData['t_id'];

            for($ic = 0; $ic < count($groups); $ic++){
                for($jc = 0; $jc < count($banks); $jc++){
                    //$model = new UserText();
                    //var_dump($model);
                    $post['UserText'] = ['p_id' => $groups[$ic], 'b_id' => $banks[$jc], 'l_id' => $l_id, 't_id' => $t_id, 'isStart' => $model->isStart ? 1 : '', 'isEnd' => $model->isEnd ? 1 : ''];
                    $model = new UserText();
                    if($model->load($post)){
                        $models[] = $model;
                    }
                }
            }

            foreach($models as $model){
                  $model->save();
            }

            return $this->redirect(['/user-text/index/' . ($model->isStart ? 'start' : 'end')]);
        }

        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/user-text/index/' . ($model->isStart ? 'start' : 'end')]);
        } else {
            return $this->render('create', [
                'model' => $model,
				'type' => $type
            ]);
        }
    }

    /**
     * Updates an existing UserText model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/user-text/index/' .($model->isStart ? 'start' : 'end'), 'id' => $model->ut_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserText model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $type = $model->isStart;
        $model->delete();
        return $this->redirect(['/user-text/index/' . ($type ? 'start' : 'end')]);
    }

    /**
     * Finds the UserText model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserText the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserText::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
