<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserText;

/**
 * UserTextSearch represents the model behind the search form about `app\models\UserText`.
 */
class UserTextSearch extends UserText
{

	public function __construct($isStart, $isEnd) {
		if ($isStart) {
            $this->isStart = 1;
        } else {
            $this->isEnd = 1;
        }


	}
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ut_id', 'p_id', 'b_id', 'l_id', 't_id', 'isStart', 'isEnd'], 'integer'],
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
        $query = UserText::find();

        $query->andWhere([
            'isStart' => $this->isStart,
            'isEnd' => $this->isEnd,
        ]);

        $pageSize = Yii::$app->session->get('pageSize',Yii::$app->params['defaultPageSize']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ut_id' => $this->ut_id,
            'p_id' => $this->p_id,
            'b_id' => $this->b_id,
            'l_id' => $this->l_id,
            't_id' => $this->t_id,
        ]);

        return $dataProvider;
    }
}
