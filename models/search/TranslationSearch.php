<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Translation;

/**
 * QuestionSearch represents the model behind the search form about `app\models\Question`.
 */
class TranslationSearch extends Translation
{
    public $questionOriginal;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tr_id'], 'integer'],
            [['t_fr_id'], 'integer'],
            [['t_l_id'], 'integer'],
            [['frage', 'antworten'], 'safe'],
            [['questionOriginal'], 'safe']
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
        $query = Translation::find();

        $pageSize = Yii::$app->session->get('pageSize',Yii::$app->params['defaultPageSize']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'tr_id',
                't_l_id',
                't_fr_id',
                'questionOriginal' => [
                    'asc' => ['{{%frage}}.frage' => SORT_ASC],
                    'desc' => ['{{%frage}}.frage' => SORT_DESC],
                    'label' => 'Frage Original'
                ],
                'frage'
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            $query->joinWith(['question']);
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tr_id' => $this->tr_id,
            't_fr_id' => $this->t_fr_id,
            't_l_id' => $this->t_l_id,
        ]);

        $query->andFilterWhere(['like', '{{%translations}}.frage', $this->frage])
            ->andFilterWhere(['like', 'antworten', $this->antworten]);

        $query->joinWith(['question' => function ($q) {
                $q->where('{{%frage}}.frage LIKE "%' . $this->questionOriginal . '%"');
            }]);

        return $dataProvider;
    }
}
