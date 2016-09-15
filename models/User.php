<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{  
    public $captcha;
    public $password_repeat;
    public $promo;
    
    public function rules() 
    {
        return [
            ];
    }
    
    public static function tableName()
    {
        return "User";
    }
    
    
    public static function findIdentity($id)
    {
       return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);    
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }
    
    public static function findByUsername($username)
    {
        return static::findOne(['name' => $username]);
    }
    
    
}


