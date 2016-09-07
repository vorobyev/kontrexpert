<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;

class Organization extends ActiveRecord 
{ 
    public $rukovod2;
    
    public function rules() 
    {
        return [
            [['name', 'fullName', 'inn', 'address'], 'required', 'message' => 'Поле обязательно для заполнения'],
            [['okpo','ogrn','kpp','rukovod'],'trueValid']
            ];
    }
    
    public function trueValid($attribute, $params)
    {
        
    }
    
    public static function tableName()
    {
        return "organizations";
    }
    
    protected function valid($inn){
        $koeffs = [2, 4, 10, 3, 5, 9, 4, 6, 8];
        $kontr = 0;
        for ($i=0;$i<strlen($inn)-1;$i++){
         $symb = (int)substr($inn,$i,1);
         $kontr = $kontr+$symb*$koeffs[$i];
        }
        $kontr = $kontr % 11;
        $kontr = $kontr % 10;
        $symb = (int)substr($inn,9,1);
        return ($symb == $kontr);
    }
    
    public function save($runValidation = false, $attributeNames = NULL)
    {
        $this->inn = str_replace("_", "",$this->inn);
        if (strlen($this->inn) != 10) {
            $this->addError('inn',"Длина ИНН должна быть равна 10 символам");
            return false;
        }
        if ($this->valid($this->inn)) {
            $this->dateReg = date("Y-m-d");
            if (!isset($this->rukovod)){
                $this->rukovod = '123';
            }

            return parent::save($runValidation);//родительский метод save
        } else {
            $this->addError('inn','ИНН введен неверно - ошибка проверки контрольного разряда');
            return false;
        }
    }    
    
}


