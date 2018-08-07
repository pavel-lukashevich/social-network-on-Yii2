<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class EditProfileForm extends Model
{
    public $username;
    public $email;
//    public $password_hash;
    public $firstname;
    public $lastname;
    public $about;
    public $password = '';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
//            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'пользователь с таким ником уже есть.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

//            [['email', 'username', 'firstname', 'lastname', 'about'], 'trim'],
//            [['email', 'username', 'firstname', 'lastname', 'about'], 'safe'],
//            [['email', 'username', 'firstname', 'lastname', 'about'], 'string', 'max' => 255],

//            [['email', 'username', 'firstname', 'lastname', 'about'], 'trim'],/**/
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
//            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'такой email уже зарегистрирован.'],
//
            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 20],
//            ['email', 'username', 'confirmPassword', 'on' => 'editProfileInfo'],
//            ['confirmPassword', 'validatePassword'],

        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function editProfileInfo()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = User::findOne(Yii::$app->user->id);

        //заполнить по всем полям формы редактирования
        if ($this->username != false) {$user->username = $this->username; }
        if ($this->email != false) {$user->email = $this->email; }
        if ($this->about != false) {$user->about = $this->about;}
        if ($this->firstname != false) {$user->firstname = $this->firstname;}
        if ($this->lastname != false) {$user->lastname = $this->lastname;}

//var_dump($user->update(true, ['username', 'email']));die;

        if ($user->update(true, ['username', 'email'])) {
            return $user;
        }else {
            return null;
        }
    }

}