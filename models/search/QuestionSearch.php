<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Question;

/**
 * QuestionSearch represents the model behind the search form about `app\models\Question`.
 */
class QuestionSearch extends Question
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fr_id'], 'integer'],
            [['frage', 'display', 'antworten', 'suche'], 'safe'],
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
        $query = Question::find();

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
            'fr_id' => $this->fr_id,
        ]);

        $query->andFilterWhere(['like', 'frage', $this->frage])
            ->andFilterWhere(['like', 'display', $this->display])
            ->andFilterWhere(['like', 'antworten', $this->antworten])
            ->andFilterWhere(['like', 'suche', $this->suche]);

        return $dataProvider;
    }
}
