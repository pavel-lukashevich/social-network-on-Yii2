<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\assets\AppAsset;
use common\models\User;
use frontend\models\EditProfile;

use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

//use yii\filters\VerbFilter;
//use yii\filters\AccessControl;

/**
 * Site controller
 */
class ProfileController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($username = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('site');
        }
        $username = ($username !== null) ? $username : Yii::$app->user->id;

        $user = User::find()->where(["id" => $username])->one();

        return $this->render('index',[
            'user' => $user,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionEdit()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('site');
        }

        $model = new EditProfile();
        if ($model->load(Yii::$app->request->post(), 'User')) {
//        /////////////////////////////////////////////////////
//        if (Yii::$app->request->post()) {
//            echo "<pre>";
//            var_dump(Yii::$app->request->post());
//            die;
//        }
//        ///////////////////////////////////////////////////
            if ($model->editProfileInfo()) {
                return $this->redirect('/profile');
            }
        }

        $model = User::find()->where(["id" => Yii::$app->user->id])->one();

        return $this->render('edit', [
            'model' => $model,
        ]);
    }
}
