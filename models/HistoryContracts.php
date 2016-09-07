<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
class HistoryContracts extends ActiveRecord
{ 
    public function rules() 
    {
        return [
            [['summ','volumeJob'],'integer','message' => 'Введите корректное число!'],
            [['idContr','dateContr'],'trueValid']
        ];
    }    
    
    public function trueValid($attribute, $params)
    {
        
    }    
    
    public static function tableName()
    {
        return "history_contracts";
    }
    
    public function save($runValidation = false, $attributeNames = NULL, $id = NULL)
    {
        if ($id == NULL) {
            $this->idContr = Yii::$app->request->get()['contrid'];
        } else {
            $this->idContr = $id;
        }
        date_default_timezone_set( 'Europe/Moscow' );
        $this->dateContr = date("Y-m-d H:i:s"); 
        return parent::save($runValidation);//родительский метод save

    }   
    
    public function getContract() {
        return $this->hasOne(Contracts::className(), ['id' => 'idContr']);
    }
    
}