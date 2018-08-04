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
     * @param integer $userId
     * @return array $friends \yii\web\Response
     */
    public function actionSubscribe($pageNum = 1, $userId = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('site');
        }

        $userId = ($userId !== null) ? $userId : Yii::$app->user->id;
        $friends = Friends::find()->select('subscribe')->where(["user_id" => $userId])->one();

//        if ($friends == null) {
//            return $this->redirect('/friends/all');
//        };

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
            return $this->redirect('site');
        }

        $userId = ($userId !== null) ? $userId : Yii::$app->user->id;
        $friends = Friends::find()->select('follower')->where(["user_id" => $userId])->one();

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
            return $this->redirect('site');
        }

        $userId = ($userId !== null) ? $userId : Yii::$app->user->id;

        $friends = Friends::find()->where(["user_id" => [$userId]])->one();

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

    public function actionAll($pageNum = 1)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('site');
        }

        $count = User::find()->count();
        $offset = Friends::FRIEND_FOR_PAGE * ($pageNum - 1);
        $friend = User::find()->select('id, username, avatar')->limit(Friends::FRIEND_FOR_PAGE)->offset($offset)->orderBy(['id' => SORT_DESC])->all();
        $pagin = new Pagination($pageNum, $count, Friends::FRIEND_FOR_PAGE);

        return $this->render('subscribe', [
            'friend' => $friend,
            'pagin' => $pagin,
           // 'count' => $count,
        ]);
    }

    public function actionAddSubscribe($follower_id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('site');
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
            return $this->redirect('site');
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

