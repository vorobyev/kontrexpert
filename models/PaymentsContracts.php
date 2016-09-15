<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
class PaymentsContracts extends ActiveRecord
{ 
    public function rules() 
    {
        return [
            ['summ','double','message' => 'Введите корректное число!'],
            [['idContr','datePayment'],'trueValid']
        ];
    }    
    
    public function trueValid($attribute, $params)
    {
        
    }    
    
    public static function tableName()
    {
        return "payments_contracts";
    }
    
    public function save($runValidation = false, $attributeNames = NULL)
    {

        return parent::save($runValidation);//родительский метод save

    }   
    
    public function getContract() {
        return $this->hasOne(Contracts::className(), ['id' => 'idContr']);
    }
    
}