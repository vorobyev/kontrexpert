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
            [['name', 'fullName', 'inn','name1c'], 'required', 'message' => 'Поле обязательно для заполнения'],
            //[['inn','kpp'],'unique','comboNotUnique' => 'Контрагент с такой парой ИНН/КПП уже существует','targetAttribute' =>['inn', 'kpp']],
			[['inn'],'unique','message' => 'Контрагент с таким ИНН уже существует'],
            [['okpo','ogrn','rukovod','saved','phone','email','kpp','addressfact', 'address'],'trueValid']
            ];
    }
    
    public function trueValid($attribute, $params)
    {
        
    }
    
    
    public static function tableName()
    {
        return "organizations";
    }
    
    // protected function valid($inn){
        // $koeffs = [2, 4, 10, 3, 5, 9, 4, 6, 8];
        // $kontr = 0;
        // for ($i=0;$i<strlen($inn)-1;$i++){
         // $symb = (int)substr($inn,$i,1);
         // $kontr = $kontr+$symb*$koeffs[$i];
        // }
        // $kontr = $kontr % 11;
        // $kontr = $kontr % 10;
        // $symb = (int)substr($inn,9,1);
        // return ($symb == $kontr);
    // }
 
protected function is_valid_inn( $inn )
{
    if ( preg_match('/\D/', $inn) ) return false;
    
    $inn = (string) $inn;
    $len = strlen($inn);
    
    if ( $len === 10 )
    {
        return $inn[9] === (string) (((
            2*$inn[0] + 4*$inn[1] + 10*$inn[2] + 
            3*$inn[3] + 5*$inn[4] +  9*$inn[5] + 
            4*$inn[6] + 6*$inn[7] +  8*$inn[8]
        ) % 11) % 10);
    }
    elseif ( $len === 12 )
    {
        $num10 = (string) (((
             7*$inn[0] + 2*$inn[1] + 4*$inn[2] +
            10*$inn[3] + 3*$inn[4] + 5*$inn[5] + 
             9*$inn[6] + 4*$inn[7] + 6*$inn[8] +
             8*$inn[9]
        ) % 11) % 10);
        
        $num11 = (string) (((
            3*$inn[0] +  7*$inn[1] + 2*$inn[2] +
            4*$inn[3] + 10*$inn[4] + 3*$inn[5] +
            5*$inn[6] +  9*$inn[7] + 4*$inn[8] +
            6*$inn[9] +  8*$inn[10]
        ) % 11) % 10);
        
        return $inn[11] === $num11 && $inn[10] === $num10;
    }
    
    return false;
}
 
    public function save($runValidation = false, $attributeNames = NULL)
    {
        $this->inn = str_replace("_", "",$this->inn);
        if ((strlen($this->inn) != 10)&&(strlen($this->inn) != 12)) {
            $this->addError('inn',"Длина ИНН должна быть равна 10 или 12 символам ");
            return false;
        }
         if ($this->is_valid_inn($this->inn)) {
            date_default_timezone_set( 'Europe/Moscow' );
            $this->dateReg = date("Y-m-d");
            // if (!isset($this->rukovod)){
                // $this->rukovod = '123';
            // }

            return parent::save($runValidation);//родительский метод save
         } else {
             $this->addError('inn','ИНН введен неверно - ошибка проверки контрольного разряда');
             return false;
         }
    }    
    
}


