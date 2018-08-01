<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "friends".
 *
 * @property int $id
 * @property int $user_id
 * @property string $subscribe
 * @property string $follower
 */
class Friends extends \yii\db\ActiveRecord
{

    const FRIEND_FOR_PAGE = 12;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'friends';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['subscribe', 'follower'], 'string'],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'user_id' => 'user_id',
            'subscribe' => 'subscribe',
            'follower' => 'follower',
        ];
    }


    public function getMutuality()
    {
        $s_arr = json_decode($this->subscribe, true);
        $f_arr = json_decode($this->follower, true);
        if ($s_arr == null || $f_arr == null)
        {
            return [];
        }
//        echo $users = implode(',', array_intersect_key(array_keys($s_arr), array_keys($f_arr)));
        $users = implode(',', array_keys(array_intersect_key($s_arr, $f_arr)));
        $subscribe = User::find('id', 'username', 'avatar')->where("id IN($users)")->all();
        return $subscribe;
    }

    public function getSubscribe()
    {
        $s_arr = json_decode($this->subscribe, true);
        if ($s_arr == null)
        {
            return [];
        }
        $users = implode(',', array_keys($s_arr));
        $subscribe = User::find('id', 'username', 'avatar')->where("id IN($users)")->all();
        return $subscribe;
    }

    public function addSubscribe($follower_id)
    {
        $s_arr = json_decode($this->subscribe, true);
        $s_arr[$follower_id] = 1; //волшебная цифра статуса отображения (которого ещё нет)
        $this->subscribe = json_encode($s_arr);
        if ($this->save(false,['subscribe'])) {
//        if ($this->save(false,['subscribe' => $this->subscribe])->where("user_id = $this->id")) {

//            $friend = Friends::find('follower')->where(['id' => $follower_id])->all();

            return true;
        }

        return false;
    }

    public function deleteSubscribe()
    {
        $s_arr = json_decode($this->subscribe, true);
        $users = implode(',', array_keys($s_arr));
        $subscribe = User::find('id', 'username', 'avatar')->where("id IN($users)")->all();
        return $subscribe;
    }

    public function getFollower()
    {
        $f_arr = json_decode($this->follower, true);
        if ($f_arr == null)
        {
            return [];
        }
        $users = implode(',', array_keys($f_arr));
        $follower = User::find('id', 'username', 'avatar')->where("id IN($users)")->all();
        return $follower;
    }
}
