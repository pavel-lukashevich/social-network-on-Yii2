<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Friends;
use common\models\User;
use common\models\Pagination;

class FriendsController extends \yii\web\Controller
{
    /**
     * список подписок
     * получает id пользователя и возвращает массив объектов друзей
     * в котором должны быть id, username, firstname, lastname, country, city
     *
     * @param integer $pageNum
     * @param integer $userId
     * @return mixed $friends \yii\web\Response
     */
    public function actionSubscribe($pageNum = 1, $userId = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        $userId = ($userId !== null) ? $userId : Yii::$app->user->id;
        $friends = Friends::find()->select('subscribe')->where(["user_id" => $userId])->one();

        if ($friends == null) {
            $friends = new Friends();
        };

        $offset = $friends::FRIEND_FOR_PAGE * ($pageNum - 1);
        $friend = $friends->getSubscribe($offset);

        $count = Friends::countSubscribe($userId);
        $pagin = new Pagination($pageNum, $count, Friends::FRIEND_FOR_PAGE);

        return $this->render('subscribe', [
            'userId' => $userId,
            'friend' => $friend,
            'pagin' => $pagin,
        ]);
    }

    /**
     * список подписчиков
     * получает id пользователя и возвращает массив объектов друзей
     * в котором должны быть id, username, firstname, lastname, country, city
     *
     * @param integer $userId
     * @return array $friends \yii\web\Response
     */
    public function actionFollower($pageNum = 1, $userId = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        $userId = ($userId !== null) ? $userId : Yii::$app->user->id;
        $friends = Friends::find()->select('follower')->where(["user_id" => $userId])->one();

        if ($friends == null) {
            $friends = new Friends();
        };

        $offset = Friends::FRIEND_FOR_PAGE * ($pageNum - 1);
        $friend = $friends->getFollower($offset);
        $count = Friends::countFollower($userId);
        $pagin = new Pagination($pageNum, $count, Friends::FRIEND_FOR_PAGE);

        return $this->render('subscribe', [
            'userId' => $userId,
            'friend' => $friend,
            'pagin' => $pagin,
        ]);
    }

    /**
     * список взаимных подписок
     * получает id пользователя и возвращает массив объектов друзей
     * в котором должны быть id, username, firstname, lastname, country, city
     *
     * @param integer $userId
     * @return array $friends \yii\web\Response
     */
    public function actionMutuality($pageNum = 1, $userId = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        $userId = ($userId !== null) ? $userId : Yii::$app->user->id;

        $friends = Friends::find()->where(["user_id" => [$userId]])->one();

        if ($friends == null) {
            $friends = new Friends();
        };

        $offset = Friends::FRIEND_FOR_PAGE * ($pageNum - 1);
        $friend = $friends->getMutuality($offset);
        $count = Friends::countMutuality($userId);
        $pagin = new Pagination($pageNum, $count, Friends::FRIEND_FOR_PAGE);

        return $this->render('subscribe', [
            'userId' => $userId,
            'friend' => $friend,
            'pagin' => $pagin,
        ]);
    }

    public function actionCommon($type, $userId = null, $pageNum = 1)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        if ($userId == null || $userId == Yii::$app->user->id){
            return $this->redirect('/friends/mutuality');
        }

        $friends = Friends::find()
            ->select($type)
            ->where(["user_id" => [$userId]])
            ->orWhere(["user_id" => Yii::$app->user->id])
            ->all();
        if ($friends[0] == null || $friends[1] == null) {
            return $this->redirect(Yii::$app->request->referrer);
        };

            $offset = Friends::FRIEND_FOR_PAGE * ($pageNum - 1);
        $str = 0;
        if ($type == 'subscribe') {
             $str = Friends::commonSubscribe($friends);
            $count = Friends::countCommonSubscribe($friends, $offset);
        }elseif ($type == 'follower') {
            $str = Friends::commonFollower($friends);
            $count = Friends::countCommonFollower($friends, $offset);
        }

        if ($pageNum > $count/Friends::FRIEND_FOR_PAGE){
            $pageNum =  $count/Friends::FRIEND_FOR_PAGE;
        }

        //var_dump($pageNum); die;
        if ($str != false) {
            $friend = User::find()->select(['id', 'username', 'avatar'])
                ->where("id IN($str)")
                ->limit(Friends::FRIEND_FOR_PAGE)
                ->offset($offset)
                ->orderBy(['id' => SORT_DESC])
                ->all();
        }else $friend = [];

        if (!$friend) {
            return $this->redirect(Yii::$app->request->referrer);
        };

         $pagin = new Pagination($pageNum, $count, Friends::FRIEND_FOR_PAGE);

        return $this->render('subscribe', [
            'userId' => $userId,
            'friend' => $friend,
            'pagin' => $pagin,
        ]);
    }

    public function actionAll($pageNum = 1)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        $count = User::find()->count();
        $offset = Friends::FRIEND_FOR_PAGE * ($pageNum - 1);
        $friend = User::find()->select('id, username, avatar')
            ->where( 'id != ' . Yii::$app->user->id)
            ->limit(Friends::FRIEND_FOR_PAGE)
            ->offset($offset)
            ->orderBy(['id' => SORT_DESC])
            ->all();
        $pagin = new Pagination($pageNum, $count, Friends::FRIEND_FOR_PAGE);

        return $this->render('subscribe', [
            'friend' => $friend,
            'pagin' => $pagin,
        ]);
    }

    public function actionAddSubscribe($follower_id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }
        $follower_id = ($follower_id !== null) ? $follower_id : Yii::$app->user->id;

        $subs = Friends::find()->where(['user_id' => Yii::$app->user->id])->one();
        if ($subs == null) $subs = new Friends();

        if ($subs->addSubscribers($follower_id)) {
            $subs->user_id = Yii::$app->user->id;
            if ($subs->save()) {

                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->redirect('/friends/all');
    }

    public function actionDeleteSubscribe($follower_id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }
        $follower_id = ($follower_id !== null) ? $follower_id : Yii::$app->user->id;

        $subs = Friends::find()->where(['user_id' => Yii::$app->user->id])->one();
        if ($subs == null) $subs = new Friends();

        if ($subs->deleteSubscribe($follower_id) || $subs->deleteSubscribe($follower_id) === null) {
            $subs->user_id = Yii::$app->user->id;
            if ($subs->save()) {

                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->redirect('/friends/all');
    }
}

