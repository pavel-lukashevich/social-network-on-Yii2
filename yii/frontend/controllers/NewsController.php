<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

//use yii\filters\VerbFilter;
//use yii\filters\AccessControl;

/**
 * Site controller
 */
class NewsController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {

            return $this->redirect('site');
        }

        return $this->render('index');
    }
}
