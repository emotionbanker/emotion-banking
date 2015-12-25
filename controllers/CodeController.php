<?php

namespace app\controllers;

use app\models\Bank;
use Yii;
use app\models\Code;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CodeController implements the CRUD actions for Code model.
 */
class CodeController extends Controller
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

    /**
     * Creates a new Code model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Code();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$count = $model->count;

			$codes = [];
			for ($i=0; $i<$count; $i++) {
				$codeModel = clone $model;
				$codeModel->code = Code::generateCode();
				$codeModel->used = 0;
				$codeModel->save();
				$codes[] = $codeModel->z_b_id . str_pad($codeModel->z_p_id, 3, '0', STR_PAD_LEFT) . $codeModel->code;

			}

            return $this->render('create-summary',[
				'codes' => $codes,
				'bank' => Bank::findOne($codeModel->z_b_id),
				'count' => $count
			]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

}
