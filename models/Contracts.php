<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
class Contracts extends ActiveRecord
{ 
    public function rules() 
    {
        return [
            [['dateContract', 'numberContract'], 'required', 'message' => 'Поле обязательно для заполнения'],
            [['comments','subj'],'trueValid']
            ];
    }    
    
    public function trueValid($attribute, $params)
    {
        
    }    
    
    public static function tableName()
    {
        return "Contracts";
    }
    
    public function save($runValidation = false, $attributeNames = NULL)
    {
        $this->idKontr = Yii::$app->request->get()['kontrid'];
        return parent::save($runValidation);//родительский метод save

    }   
    
    public function getClient() {
        return $this->hasOne(Organization::className(), ['id' => 'idKontr']);
    }
    
}