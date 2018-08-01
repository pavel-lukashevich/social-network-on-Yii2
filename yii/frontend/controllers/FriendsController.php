<?php

namespace frontend\controllers;

use Yii;

class FriendsController extends \yii\web\Controller
{
    public function actionIndex($userId = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('site');
        }

        $userId = ($userId !== null) ? $userId : Yii::$app->user->id;

//        $user = Friends::find()->where(["user_id" => $userId])->one();

        return $this->render('index', [
            'userId' => $userId,
        ]);
    }

    public function actionAll()
    {
        return $this->render('all');
    }

}
