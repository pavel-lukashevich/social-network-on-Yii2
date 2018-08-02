<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use frontend\models\EditProfile;
use yii\web\UploadedFile;
use yii\web\Response;
use frontend\models\AvatarLoader;

use frontend\models\UploadForm;
use frontend\assets\AppAsset;
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

        $modelAvatar = new AvatarLoader();

        $username = ($username !== null) ? $username : Yii::$app->user->id;

        $user = User::find()->where(["id" => $username])->one();

        if ($user == null) {
            return $this->redirect('/profile');
        }

        return $this->render('index', [
            'user' => $user,
            'modelAvatar' => $modelAvatar,
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
            if ($model->editProfileInfo()) {
                return $this->redirect('/profile');
            }
        }

        $model = User::find()->where(["id" => Yii::$app->user->id])->one();

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * заггрузка изображений, из учебника
     *
     * @return string|\yii\web\Response
     */
//    public function actionUpload()
//    {
//        $model = new UploadForm();
//
//        if (Yii::$app->request->isPost) {
//            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
//            if ($model->upload()) {
//                // file is uploaded successfully
//                return $this->redirect('/profile');
//            }
//        }
//
//        return $this->render('upload', ['model' => $model]);
//    }

    public function actionUploadPicture()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new AvatarLoader();

      $model->picture = UploadedFile::getInstance($model, "picture");

        if ($model->validate()) {

            $user = User::find()->where(["id" => Yii::$app->user->id])->one();

            $user->avatar = Yii::$app->storage->saveUploadedFile($model->picture); // 15/27/30/379e706840f951d22de02458a4788eb55f.jpg

            if ($user->save(false, ['avatar'])) {

                return [
                    'success' => true,
                    'pictureUri' => Yii::$app->storage->getFile($user->avatar),
                ];
            }
        }
        return ['success' => false, 'errors' => $model->getErrors()];

//            ///////////////////////////////
//           echo "<pre>";
//           echo '+++';var_dump($user->save(false, ['avatar'])); die('++++');
//            ///////////////////////////////

    }
}
