<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Friends;
use common\models\User;
use common\models\Pagination;

class FriendsController extends \yii\web\Controller
{
    public function actionIndex($userId = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('site');
        }

        $userId = ($userId !== null) ? $userId : Yii::$app->user->id;
        $friends = Friends::find('subscribe')->where(["user_id" => $userId])->one();

        if ($friends == null){
            return $this->redirect('/friends/all');
        };


        return $this->render('index', [
            'userId' => $userId,
            'friends' => $friends,
        ]);
    }

    public function actionFollower($userId = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('site');
        }

        $userId = ($userId !== null) ? $userId : Yii::$app->user->id;
        $friends = Friends::find('follower')->where(["user_id" => $userId])->one();

        if ($friends == null){
            return $this->redirect('/friends/all');
        };


        return $this->render('follower', [
            'userId' => $userId,
            'friends' => $friends,
        ]);
    }

    public function actionMutuality($userId = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('site');
        }

        $userId = ($userId !== null) ? $userId : Yii::$app->user->id;
        $friends = Friends::find()->where(["user_id" => $userId])->one();

        return $this->render('mutuality', [
            'userId' => $userId,
            'friends' => $friends,
        ]);
    }

    public function actionAll($pageNum = 1)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('site');
        }

        $count = User::find()->count();
        $offset = Friends::FRIEND_FOR_PAGE * ($pageNum - 1);
        $user = User::find()->select('id, username, avatar')->limit(Friends::FRIEND_FOR_PAGE)->offset($offset)->orderBy(['id' => SORT_DESC])->all();
        $pagin = new Pagination($pageNum, $count, Friends::FRIEND_FOR_PAGE);

        return $this->render('all', [
            'user' => $user,
            'pagin' => $pagin,
            'count' => $count,
        ]);
    }

    //return $this->redirect(Yii::$app->request->referrer);
    public function actionAddSubscribe($follower_id = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('site');
        }

        $follower_id = ($follower_id !== null) ? $follower_id : Yii::$app->user->id;

        $subs = Friends::findOne(['user_id' => Yii::$app->user->id]);
        if ($subs->addSubscribe($follower_id)) {
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->redirect('friends/all');
    }

}
