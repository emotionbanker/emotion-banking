<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Form;

/**
 * FormSearch represents the model behind the search form about `app\models\Form`.
 */
class FormSearch extends Form
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['f_id', 'f_p_id'], 'integer'],
            [['f_klasse', 'reihenfolge', 'history'], 'safe'],
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
        $query = Form::find();

        $pageSize = Yii::$app->session->get('pageSize',50);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'f_id' => $this->f_id,
            'f_p_id' => $this->f_p_id,
        ]);

        $query->andFilterWhere(['like', 'f_klasse', $this->f_klasse])
            ->andFilterWhere(['like', 'reihenfolge', $this->reihenfolge])
            ->andFilterWhere(['like', 'history', $this->history]);

        return $dataProvider;
    }
}
