<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Friends;

class FriendsController extends \yii\web\Controller
{
    public function actionIndex($userId = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('site');
        }

        $userId = ($userId !== null) ? $userId : Yii::$app->user->id;

        $friends = Friends::find()->where(["user_id" => $userId])->one();

        return $this->render('index', [
            'userId' => $userId,
            'friends' => $friends,
        ]);
    }

    public function actionAll()
    {
        return $this->render('all');
    }

}
