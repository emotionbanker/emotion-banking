<?php

namespace app\models\search;

use app\models\QuestionAlias;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * QuestionSearch represents the model behind the search form about `app\models\Question`.
 */
class QuestionAliasSearch extends QuestionAlias
{

	public function __construct($questionId) {
		$this->a_fr_id = $questionId;
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['al_id'], 'safe'],
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
        $query = QuestionAlias::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		$query->andFilterWhere([
			'a_fr_id' => $this->a_fr_id,
		]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['al_id' =>$this->al_id]);
        return $dataProvider;
    }
}
