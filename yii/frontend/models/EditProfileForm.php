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
    public $firstname;
    public $lastname;
    public $about;
    public $country;
    public $city;
    public $education;
    public $job;
//    public $birthsday;
//    public $phone;
    public $password = '';

    private $_user;


    public function rules()
    {
        return [
            [['username'], 'required', 'on' => 'editUsername'],
            [['password'], 'required', 'on' => ['editEmail', 'editUsername']],
            [['about'], 'string', 'max' => 5000, 'on' => ['editInfo']],
            [['firstname', 'lastname', 'country', 'city', 'education', 'job'], 'string', 'max' => 255, 'on' => ['editInfo']],
            [['firstname', 'lastname', 'about', 'country', 'city', 'education', 'job'], 'trim'],
//            [['phone'], 'integer'],
//            [['birthsday'], 'integer'],

            [['email'], 'required', 'on' => 'editEmail'],
            ['username', 'trim'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'email'],

            ['password', 'string', 'min' => 6],

        ];
    }

    /**
     * @return User|null
     */
    protected function getEmail()
    {
        if ($this->_user === null) {
            $this->_user = User::findOne(Yii::$app->user->id);
        }
        return $this->_user;
    }


    /**
     * @return User|null
     */
    public function editUsername()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = User::findOne(Yii::$app->user->id);

        if ($user->validatePassword($this->password)) {

            if ($user->uniqueUsername($this->username)) {
                $user->username = $this->username;
                return $user->save() ? $user : null;
            } else {
//добавить флэшку имя занято
            }
        }else {
        $this->password = '';
//  добавить флэшку пароль неправильный
        return null;
        }

    }


    /**
     * @return User|null
     */
    public function editEmail()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = User::findOne(Yii::$app->user->id);

        if ($user->validatePassword($this->password)) {

            if ($user->uniqueEmail($this->email)) {
                $user->email = $this->email;
                return $user->save() ? $user : null;
            } else {
//добавить флэшку имя занято
            }
        }else {
            $this->password = '';
//  добавить флэшку пароль неправильный
            return null;
        }
    }


    /**
     * @return User|null
     */
    public function editInfo()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = User::findOne(Yii::$app->user->id);

        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->country = $this->country;
        $user->city = $this->city;
//        $user->birthsday = $this->birthsday;
//        $user->phone = $this->phone;
        $user->education = $this->education;
        $user->job = $this->job;
        $user->about = $this->about;

        return $user->save() ? $user : null;
    }

}