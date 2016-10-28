<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Organization;
use app\models\Contracts;
use yii\helpers\ArrayHelper;

/**
 * OrganizationSearch represents the model behind the search form about `app\models\Organization`.
 */
class OrganizationSearch extends Organization
{
    public $contract;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['rukovod', 'fullName', 'name', 'inn', 'kpp', 'okpo', 'ogrn', 'dateReg', 'address','email','contract'], 'safe'],
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
        $query = Organization::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 20,
			],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        if (!empty($this->contract)){
            $contracts = Contracts::find()->where(['like', 'numberContract', $this->contract])->all();
        
            $contr_ids = [];
            foreach ($contracts as $contract) {
                $contr_ids = ArrayHelper::merge($contr_ids, [$contract->idKontr]);
            }
            $query->andFilterWhere(['id'=>$contr_ids]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            //'id' => $this->id,
            'dateReg' => $this->dateReg,
        ]);

        $query->andFilterWhere(['like', 'rukovod', $this->rukovod])
            ->andFilterWhere(['like', 'fullName', $this->fullName])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'inn', $this->inn])
            ->andFilterWhere(['like', 'kpp', $this->kpp])
            ->andFilterWhere(['like', 'okpo', $this->okpo])
            ->andFilterWhere(['like', 'ogrn', $this->ogrn])
			->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'address', $this->address]);
                

        return $dataProvider;
    }
}
