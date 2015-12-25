<?php

namespace app\models\search;

use app\models\Code;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * QuestionSearch represents the model behind the search form about `app\models\Question`.
 */
class CodeSearch extends Code
{

    public $fillingDate;
    public $duration;

	public function __construct($bankId) {
		$this->z_b_id = $bankId;
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['z_p_id', 'used', 'status'], 'integer'],
			[['code'], 'string', 'max' => 13],
            [['fillingDate', 'duration'], 'safe']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = Code::find();

        $pageSize = Yii::$app->session->get('pageSize',Yii::$app->params['defaultPageSize']);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
		]);

        $dataProvider->setSort([
            'attributes' => [
                'code',
                'z_p_id',
                'status',
                'fillingDate' => [
                    'asc' => ['{{%meta}}.time_start' => SORT_ASC],
                    'desc' => ['{{%meta}}.time_start' => SORT_DESC],
                    'label' => 'Filling Date'
                ],
                'duration' => [
                    'asc' => ['{{%meta}}.time_end' => SORT_ASC],
                    'desc' => ['{{%meta}}.time_end' => SORT_DESC],
                    'label' => 'Duration'
                ],
            ]
        ]);

		/*$query->andFilterWhere([
			'z_b_id' => $this->z_b_id,
		]);*/

		if (!($this->load($params) && $this->validate())) {
            $query->joinWith(['meta']);
			return $dataProvider;
		}

		if (!$this->status) {
			$query->andFilterWhere([
				'status' => $this->status,
			]);
		} else {
            $query->andFilterWhere(['>', 'status', $this->status]);
            if($this->status == 1){
                $query->andFilterWhere(['=', 'used', 0]);
            }else{
                $query->andFilterWhere(['=', 'used', 1]);
            }
		}

        if(isset($this->z_p_id) && !empty($this->z_p_id)){
            $query->andFilterWhere([
                'z_p_id' => $this->z_p_id,
            ]);
        }

		$query->andFilterWhere(['like', 'CONCAT("' . $this->z_b_id . '", LPAD(`z_p_id`,3,"0"),`code`)', $this->code]);

        $query->joinWith(['meta' => function ($q) {
                if(isset($this->z_id) && !empty($this->z_id)){
                    $q->where('{{%meta}}.m_z_id = "' . $this->z_id . '"');
                }
            }]);

        //echo $query->createCommand()->getRawSql();
        //exit();


		return $dataProvider;
	}
}
