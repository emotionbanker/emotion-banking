<?php

namespace app\models\search;

use app\models\Code;
use app\models\Group;
use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;


/**
 * QuestionSearch represents the model behind the search form about `app\models\Question`.
 */
class Statistic extends Model
{

	public $z_b_id;
	public $tic_count;
	public $z_p_id;

	public function __construct($bankId) {
		$this->z_b_id = $bankId;
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [

		];
	}

	public function scenarios()
	{
		return Model::scenarios();
	}

	public function search()
	{
		$count = Yii::$app->db->createCommand("SELECT
				COUNT(DISTINCT (z_p_id))
				from " . Code::tableName(). "
				where LOWER(z_b_id) = :bank
				", [':bank' => strtolower($this->z_b_id)])->queryScalar();

		$dataProvider = new SqlDataProvider([
			'sql' => "select
				bezeichnung,
				count(z_b_id) as tic_count,
				SUM(if(used = 1, 1, 0)) AS bused,
				SUM(if(status > 49 and used=0, 1, 0)) AS bused50,
				SUM(if(status > 49 or used = 1, 1, 0)) AS busedtot
				from " .  Code::tableName() .", " . Group::tableName() . "
				where LOWER(z_b_id) = :bank and z_p_id = p_id
				group by z_p_id",
			"params" => [':bank' => strtolower($this->z_b_id)],
			'totalCount' => $count
		]);

		return $dataProvider;
	}
}
