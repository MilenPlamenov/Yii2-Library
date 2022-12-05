<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $email;
    public $password;
    public $password_repeat;
    public $first_name;
    public $last_name;
    public $address;
    public $telephone_number;

    public function rules()
    {
        return [
            [['email'], 'unique'],
            [['email', 'first_name', 'last_name', 'password', 'password_repeat', 'telephone_number'], 'required'],
            ['email', 'email', 'message' => 'Incorrect email'],
            [['address', 'email'], 'safe'],
            [['password', 'password_repeat'], 'string', 'min' => 8],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['telephone_number', 'integer'],
            [['telephone_number'], 'udokmeci\yii2PhoneValidator\PhoneValidator'],
        ];
    }

    public function validatePhone($phone) {
        if(!preg_match('/^[0-9]{10}+$/', $phone)) {
            $this->addError($phone, 'Please enter valid phone number!');
        }
    }

    public function register() {
        $user = new User();
        $user->email = $this->email;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->address = $this->address;
        $user->telephone_number = $this->telephone_number;
        $user->password = Yii::$app->security->generatePasswordHash($this->password);
        $user->access_token = Yii::$app->security->generateRandomString();
        $user->auth_key = Yii::$app->security->generateRandomString();

        if($user->save()) {
            return true;
        }
        Yii::$app->session->setFlash('error', 'Invalid data');
        return false;
    }
}