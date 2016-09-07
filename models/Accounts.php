<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
class Accounts extends ActiveRecord
{ 
    public function rules() 
    {
        return [
            [['kontrAccount', 'bankName', 'bik'], 'required', 'message' => 'Поле обязательно для заполнения'],
            [['idKontr','korrAccount','address','city'],'trueValid']
            ];
    }    
    
    public function trueValid($attribute, $params)
    {
        
    }    
    
    public static function tableName()
    {
        return "Accounts";
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