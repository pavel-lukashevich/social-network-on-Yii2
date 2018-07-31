<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

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
//            ['username', 'trim'],
//            ['username', 'required'],
//            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
//            ['username', 'string', 'min' => 2, 'max' => 255],

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
/*
//        $user = User::find()->where([\'id\' => Yii::$app->user->id])->one();
//        if ($_REQUEST['username'] != false) {
//            $user->username = $_REQUEST['username'];
*/
        $user = User::findOne(Yii::$app->user->id);
        if ($this->username != false) {
            $user->username = $this->username;
        }

        return $user->save() ? $user : null;
    }
}