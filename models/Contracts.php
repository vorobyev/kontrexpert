<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use app\models\Organization;

class Contracts extends ActiveRecord
{ 
    public function rules() 
    {
        return [
            [['dateContract', 'numberContract'], 'required', 'message' => 'Поле обязательно для заполнения'],
            [['comments','subj','saved'],'trueValid']
            ];
    }    
    
    public function trueValid($attribute, $params)
    {
        
    }    
    
    public static function tableName()
    {
        return "Contracts";
    }
    
    public function save($runValidation = false, $attributeNames = NULL, $mode = NULL)
    {
        if ($mode!='1c'){
            $this->idKontr = Yii::$app->request->get()['kontrid'];
            $org = Organization::findOne($this->idKontr);
            $org->saved = '0';
            $org->save(false,null,'register');
            $this->saved = '0';
            return parent::save($runValidation);//родительский метод save
        } else {
            return parent::save($runValidation);
        }
    }   
    
    public function getClient() {
        return $this->hasOne(Organization::className(), ['id' => 'idKontr']);
    }
    
}