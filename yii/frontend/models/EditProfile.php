<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\validators\ImageValidator;
use yii\web\UploadedFile;

/**
 * Signup form
 */
class EditProfile extends Model
{
    public $username;
    public $email;
    public $firstname;
    public $lastname;
    public $about;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            // сделать свою проверку на уник и id
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'пользователь с таким ником уже есть.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            [['email', 'username', 'firstname', 'lastname', 'about'], 'safe'],
            [['email', 'username', 'firstname', 'lastname', 'about'], 'string', 'max' => 255],

//            [['email', 'username', 'firstname', 'lastname', 'about'], 'trim'],/**/
//            ['email', 'trim'],
//            ['email', 'required'],
//            ['email', 'email'],
//            ['email', 'string', 'max' => 255],
//            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
//
//            ['password', 'required'],
//            ['password', 'string', 'min' => 6],

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
        if ($this->about != false) {$user->about = $this->about;}
        if ($this->firstname != false) {$user->firstname = $this->firstname;}
        if ($this->lastname != false) {$user->lastname = $this->lastname;}


        if ($user->save(false, ['username', 'about', 'firstname', 'lastname'])) {
            return $user;
        }else return null;
    }
}