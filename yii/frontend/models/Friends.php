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

    const FRIEND_FOR_PAGE = 10;

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

    /**
     * @return array|mixed
     */
    public function getMySubscribersList()
    {
        if ($this->subscribe || $this->subscribe != 'null') {
            $s_arr = json_decode($this->subscribe, true);
        } else $s_arr = [];
        return $s_arr;
    }

    /**
     * @return array|mixed
     */
    public function getMyFollowerList()
    {
        if ($this->follower || $this->follower != 'null') {
            $f_arr = json_decode($this->follower, true);
        } else $f_arr = [];
        return $f_arr;
    }

    /**
     * @param $offset
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getSubscribe($offset)
    {
        $s_arr = $this->getMySubscribersList();

        if ($s_arr == null) return [];

        $users = implode(',', array_keys($s_arr));


        $subscribe = User::find()->select(['id', 'username', 'avatar'])
            ->where("id IN($users)")
            ->limit(Friends::FRIEND_FOR_PAGE)
            ->offset($offset)
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $subscribe;
    }

    /**
     * @param $offset
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getFollower($offset)
    {
        $f_arr = json_decode($this->follower, true);

        if ($f_arr == null) return [];

        $users = implode(',', array_keys($f_arr));

        $follower = User::find()->select(['id', 'username', 'avatar'])
            ->where("id IN($users)")
            ->limit(Friends::FRIEND_FOR_PAGE)
            ->offset($offset)
            ->orderBy(['id' => SORT_DESC])
            ->all();
        return $follower;
    }

    /**
     * @param $offset
     * @return array|\yii\db\ActiveRecord[]
     *
     */
    public function getMutuality($offset)
    {
        $s_arr = $this->getMySubscribersList();
        $f_arr = $this->getMyFollowerList();

        if ($s_arr == null || $f_arr == null) return [];

       $users = implode(',', array_keys(array_intersect_key($s_arr, $f_arr)));

       if ($users == null) return [];

        $subscribe = User::find()->select(['id', 'username', 'avatar'])
            ->where("id IN($users)")
            ->limit(Friends::FRIEND_FOR_PAGE)
            ->offset($offset)
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $subscribe;
    }

    /**
     * @param $follower_id
     * @return bool|string
     */
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

    /**
     * @param $follower_id
     * @return bool
     */
    public function addFollower($follower_id)
    {
        $follower = Friends::find()->where(['user_id' => $follower_id])->one();
        if ($follower == null) {
            $follower = new Friends();
            $follower->user_id = $follower_id;
        }
        $f_arr = $follower->getMyFollowerList();

        $f_arr[Yii::$app->user->id] = 1; //волшебная цифра статуса отображения (которого ещё нет)
        $follower->follower = json_encode($f_arr);
        if ($follower->save()) {
            return true;
        }
        return false;
    }

    /**
     * @param $follower_id
     * @return bool|null|string
     */
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

    /**
     * @param $follower_id
     * @return bool
     */
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

    /**
     * @param $user_id
     * @return bool
     */
    public static function isSubscribe($user_id)
    {
        $user = Friends::find()->where(['user_id' => Yii::$app->user->id])->one();
        if ($user == null) return false;

        $s_arr = $user->getMySubscribersList();
        if ($s_arr == null) return false;

        $i["$user_id"] = '1';
        $equals = array_intersect_key($s_arr, $i);

        if ($equals != null) {
            return true;
        }

        return false;
    }

    /**
     * @param $user_id
     * @return int
     */
    public static function countSubscribe($user_id)
    {
        $user = self::find()->select(['subscribe'])->where(['user_id' => $user_id])->one();
        if ($user == null) return 0;
        $s_arr = $user->getMySubscribersList();
        return count($s_arr);
    }

    /**
     * @param $user_id
     * @return int
     */
    public static function countFollower($user_id)
    {
        $user = self::find()->select(['follower'])->where(['user_id' => $user_id])->one();
        if ($user == null) return 0;
        $f_arr = $user->getMyFollowerList();
        return count($f_arr);
    }

    /**
     * @param $user_id
     * @return int
     */
    public static function countMutuality($user_id)
    {
        $user = self::find()->select(['subscribe', 'follower'])->where(['user_id' => $user_id])->one();
        if ($user == null) return 0;
        $s_arr = $user->getMySubscribersList();
        $f_arr = $user->getMyFollowerList();
        if ($s_arr == null || $f_arr == null) return 0;
        return count(array_intersect_key($s_arr, $f_arr));
    }

    /**
     * @param $users
     * @return bool|string
     */
    public static function commonSubscribe($users)
    {

        $arr1 = $users[0]->getMySubscribersList();
        $arr2 = $users[1]->getMySubscribersList();

        if (!$arr1 || !$arr2) return false;
        $equals = array_intersect_key($arr1, $arr2);

        if ($equals) {
            $str = implode(', ',array_keys($equals));
            return $str;
        }

        return false;
    }

    /**
     * @param $users
     * @return bool|string
     */
    public static function commonFollower($users)
    {
        $arr1 = $users[0]->getMyFollowerList();
        $arr2 = $users[1]->getMyFollowerList();

        if (!$arr1 || !$arr2) return false;
        $equals = array_intersect_key($arr1, $arr2);

        if ($equals) {
            $str = implode(', ',array_keys($equals));
            return $str;
        }
        return false;
    }

    /**
     * @param $users
     * @return int
     */
    public static function countCommonSubscribe($users)
    {
        $arr1 = $users[0]->getMySubscribersList();
        $arr2 = $users[1]->getMySubscribersList();

        if (!$arr1 || !$arr2) return 0;
        return count(array_intersect_key($arr1, $arr2));

    }

    /**
     * @param $users
     * @return int
     */
    public static function countCommonFollower($users)
    {
        $arr1 = $users[0]->getMyFollowerList();
        $arr2 = $users[1]->getMyFollowerList();

        if (!$arr1 || !$arr2) return 0;
        return count(array_intersect_key($arr1, $arr2));

    }

}
