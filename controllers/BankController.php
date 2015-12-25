<?php

namespace app\controllers;

use app\models\Alias;
use app\models\Code;
use app\models\search\CodeSearch;
use app\models\search\GroupSearch;
use app\models\search\Statistic;
use Yii;
use app\models\Bank;
use app\models\search\BankSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * BankController implements the CRUD actions for Bank model.
 */
class BankController extends Controller
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
     * Lists all Bank models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BankSearch();
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
     * Displays a single Bank model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Bank model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bank();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->b_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	 public function actionFf(){
		 echo "Samet";
	 }
    /**
     * Updates an existing Bank model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->b_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Bank model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


	public function actionCodes($bankId) {
		$searchModel = new CodeSearch($bankId);
        if (isset($_GET['pageSize'])) {
            Yii::$app->session->set('pageSize',(int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }
		$dataProvider = $searchModel->search(
			\Yii::$app->request->queryParams
		);

		$model = $this->findModel($bankId);

		return $this->render('codes',[
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionDeleteCode($bankId, $cid)
	{
		Code::findOne($cid)->delete();

		return $this->redirect(['bank/' . $bankId . '/codes']);
	}

	public function actionLock($bankId)
	{
		$searchModel = new GroupSearch();
		$dataProvider = $searchModel->search(
			\Yii::$app->request->queryParams
		);

		$model = $this->findModel($bankId);

		return $this->render('lock',[
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}
	public function actionLockUnlock($bankId)
	{
		$group = Yii::$app->request->get('p_id');
		$bank = Bank::findOne($bankId);
		$bank->lockUnlock($group);

		$this->redirect(['/bank/' . $bankId . '/lock']);
	}

	public function actionStatistic($bankId)
	{
		$model = $this->findModel($bankId);
		$searchModel = new Statistic($bankId);
		$dataProvider = $searchModel->search(
			\Yii::$app->request->queryParams
		);
		return $this->render('statistic',[
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionStatisticList()
	{
		//$model = $this->findModel($bankId);
/*		$searchModel = new Statistic($bankId);
		$dataProvider = $searchModel->search(
			\Yii::$app->request->queryParams
		);*/
		return $this->render('statistic-list',[
			'list' => Bank::find()->orderBy('bezeichnung')->all(),
		]);
	}


	public function actionPlaceholders()
	{
        $error = Yii::$app->session->getFlash('error');
		return $this->render('placeholder',[
            'error' => $error
		]);
	}

	public function actionSetAlias()
	{
		$banks = Yii::$app->request->get('bank');
        if(empty($banks)){
            $error = "Fehler: Keine Bank wurde ausgewählt";
            Yii::$app->session->setFlash('error',$error);
            return $this->redirect(['/bank/placeholders']);
        }

		$sBanks = "'" . join("','",$banks) . "'";

		$action = Yii::$app->request->post('action');

		if ($action == 'add') {
			$addAlias = Yii::$app->request->post('alias');
			foreach ($banks as $bank) {
				if ($addAlias['new']['original'] && $addAlias['new']['alias']) {
					$present = Alias::findOne([
						'original' => $addAlias['new']['original'],
						'b_id' => $bank
					]);
					if (! $present) {
						$alias = new Alias();
						$alias->b_id = $bank;
						$alias->original = $addAlias['new']['original'];
						$alias->alias = $addAlias['new']['alias'];
						$alias->save();
					}
				}
			}
		}

		$sql = "SELECT original, alias, count(*) as cnt FROM {{%alias}}
				WHERE b_id IN ($sBanks)
				GROUP BY original, alias";

		$command = Yii::$app->db->createCommand($sql);
		$aliases = $command->queryAll();

		$aliasesData = Yii::$app->request->post('alias');

		if (strpos($action, 'save') !==false ) {
			$key = explode('-',$action)[1];
			$aliasToSave = $aliases[$key];
			if ($aliasesData[$key]['original'] && $aliasesData[$key]['alias']) {
				foreach ($banks as $bank) {
					$alias = Alias::findOne([
						'original' => $aliasToSave['original'],
						'b_id' => $bank
					]);
					$alias->original = $aliasesData[$key]['original'];
					$alias->alias = $aliasesData[$key]['alias'];
					$alias->save();
				}
			}
		}

		if (strpos($action, 'delete') !==false ) {
			$key = explode('-',$action)[1];
			$aliasToDelete = $aliases[$key];
			foreach ($banks as $bank) {
				Alias::findOne([
					'original' =>$aliasToDelete['original'],
					'b_id' => $bank
				])->delete();
			}
		}


		$sql = "SELECT original, alias, count(*) as cnt FROM {{%alias}}
				WHERE b_id IN ($sBanks)
				GROUP BY original, alias";

		$command = Yii::$app->db->createCommand($sql);
		$aliases = $command->queryAll();

		return $this->render('alias',[
			'banks' => Bank::findAll(['b_id' => $banks]),
			'aliases' => $aliases
		]);
	}

    /**
     * Finds the Bank model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Bank the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bank::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
    public function actionImport()
	{
		$imported = 0;
		$dropped = 0;
        $postData = Yii::$app->request->post();
		$file = UploadedFile::getInstanceByName('filename');
		if ($file) {
			$content = file($file->tempName);
            $lines = 0;
			try {
                foreach ($content  as $line) {
                    $lines++;
					echo $lines;
                    $bank = explode('@', $line);
					
					$oBank = new Bank();
					$oBank->b_id = $bank[0];
					$oBank->bezeichnung = $bank[1] ;
					$oBank->klasse = $bank[2];
					if($oBank->save()){
						$imported++;
					}else{
						$dropped++;
					}
                }
                if($imported == 0){
                    return $this->render('upload', [
                        'warning' => "Type option is invalid or not found. Check format of the file",
                        'imported' => 0,
                        'dropped' => 0,
                    ]);
                }
            }
            catch (ErrorException $e) {
                return $this->render('upload', [
                    'warning' => "Invalid character was found at line ". $lines . ". Imported questions " . $imported,
                    'imported' => 0,
                    'dropped' => 0,
                ]);
            }
		}elseif(!empty($postData)){
            return $this->render('upload', [
                'error' => "No file was selected to import",
                'imported' => $imported,
                'dropped' => $dropped,
            ]);
        }

		return $this->render('upload', [
			'imported' => $imported,
			'dropped' => $dropped,
		]);
	}
}
