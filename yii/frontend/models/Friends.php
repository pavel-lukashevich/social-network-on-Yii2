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

    public function getMySubscribersList()
    {
        if ($this->subscribe != null) {
            $s_arr = json_decode($this->subscribe, true);
        } else $s_arr = null;
        return $s_arr;
    }

    public function getMyFollowerList()
    {
        if ($this->subscribe != null) {
            $f_arr = json_decode($this->follower, true);
        } else $f_arr = null;
        return $f_arr;
    }

    public function getSubscribe()
    {
        $s_arr = $this->getMySubscribersList();

        if ($s_arr == null) return [];

        $users = implode(',', array_keys($s_arr));
        $subscribe = User::find('id', 'username', 'avatar')->where("id IN($users)")->all();
        return $subscribe;
    }

    public function getFollower()
    {
        $f_arr = json_decode($this->follower, true);
        if ($f_arr == null) {
            return [];
        }
        $users = implode(',', array_keys($f_arr));
        $follower = User::find('id', 'username', 'avatar')->where("id IN($users)")->all();
        return $follower;
    }

    public function getMutuality()
    {
        $s_arr = $this->getMySubscribersList();
        $f_arr = $this->getMyFollowerList();

        if ($s_arr == null || $f_arr == null) return [];

       $users = implode(',', array_keys(array_intersect_key($s_arr, $f_arr)));

       if ($users == null) return [];

        $subscribe = User::find('id', 'username', 'avatar')->where("id IN($users)")->all();

        return $subscribe;
    }

    public function addSubscribers($follower_id)
    {
        $s_arr = $this->getMySubscribersList();

        $s_arr[$follower_id] = 1; //волшебная цифра статуса отображения (которого ещё нет)
        $this->subscribe = json_encode($s_arr);

        if ($this->addFollower($follower_id)) {
            return $this->subscribe;
        }
        return false;
    }

    public function addFollower($follower_id)
    {
        $follower = Friends::find()->where(['user_id' => $follower_id])->one();
        $f_arr = $follower->getMyFollowerList();

        $f_arr[Yii::$app->user->id] = 1; //волшебная цифра статуса отображения (которого ещё нет)
        $follower->follower = json_encode($f_arr);
        if ($follower->save()) {
            return true;
        }
        return false;
    }

    public function deleteSubscribe($follower_id)
    {
        $s_arr = $this->getMySubscribersList();

        unset($s_arr[$follower_id]);
        $this->subscribe = $s_arr == null ? null : json_encode($s_arr);

        if ($this->deleteFollower($follower_id)) {
            return $this->subscribe;
        }
        return false;
    }

    public function deleteFollower($follower_id)
    {
        $follower = Friends::find()->where(['user_id' => $follower_id])->one();
        $f_arr = $follower->getMyFollowerList();

        unset($f_arr[Yii::$app->user->id]);
        $follower->follower = $f_arr == null ? null : json_encode($f_arr);

        if ($follower->save()) {
            return true;
        }
        return false;
    }


}
