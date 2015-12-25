<?php

namespace app\models\search;

use app\models\Style;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bank;

/**
 * BankSearch represents the model behind the search form about `app\models\Style`.
 */
class StylesSearch extends Style
{
    public $bankName;
    public $groupName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['s_b_id'], 'integer'],
            [['s_p_id'], 'integer'],
            [['style'], 'safe'],
            [['bankName'], 'safe'],
            [['groupName'], 'safe']
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
        $query = Style::find();

        $pageSize = Yii::$app->session->get('pageSize',20);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => $pageSize,
			]
        ]);

        $dataProvider->setSort([
            'attributes' => [
                's_id',
                's_b_id',
                's_p_id',
                'bankName' => [
                    'asc' => ['{{%bank}}.bezeichnung' => SORT_ASC],
                    'desc' => ['{{%bank}}.bezeichnung' => SORT_DESC],
                    'label' => 'Bankenname'
                ],
                'groupName' => [
                    'asc' => ['{{%personen}}.bezeichnung' => SORT_ASC],
                    'desc' => ['{{%personen}}.bezeichnung' => SORT_DESC],
                    'label' => 'Gruppenname'
                ],
                'style'
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'style', $this->style]);

        $query->joinWith(['bank' => function ($q) {
                $q->where('{{%bank}}.bezeichnung LIKE "%' . $this->bankName . '%"');
            }]);
        $query->joinWith(['group' => function ($q) {
                $q->where('{{%personen}}.bezeichnung LIKE "%' . $this->groupName . '%"');
            }]);
        return $dataProvider;
    }
}
