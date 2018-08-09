<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use frontend\models\EditProfileForm;
use yii\web\UploadedFile;
use yii\web\Response;
use frontend\models\ImageLoader;

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
    public function actionIndex($userId = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        $modelImage = new ImageLoader();

        $userId = ($userId !== null) ? $userId : Yii::$app->user->id;

        $user = User::infoForProfile($userId);

        if ($user == null) {
            return $this->redirect('/profile');
        }

        return $this->render('index', [
            'user' => $user,
            'modelImage' => $modelImage,
        ]);
    }


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function actionEdit()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }
        $model = new EditProfileForm();

        if ($model->load(Yii::$app->request->post(), 'User')) {

            if (isset($_POST['edit_username'])) {
                if ($model->editUsername() != null) {
                   // добавить флэшки
                    return $this->refresh();
                }
            }elseif (isset($_POST['edit_email'])) {
                if ($model->editEmail() != null) {
                    // добавить флэшки
                    return $this->refresh();
                }
            }elseif (isset($_POST['edit_info'])) {
                if ($model->editInfo() != null) {
                    // добавить флэшки
                    return $this->refresh();
                }
            }
        }else $model = User::infoForProfile();

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//    public function actionEdit()
//    {
//        if (Yii::$app->user->isGuest) {
//            return $this->redirect('/site');
//        }
//
//        $model = new EditProfileForm();
//
//
////echo (!empty(Yii::$app->request->post()->button2)) ? '+' : '-';
//
////        $request = $model->load(Yii::$app->request->post(), 'User');
//        $request = $model->load(Yii::$app->request->post(), 'User');
////        $model = User::infoForProfile($userId);
//        if ($request) {
//
//            if (isset($_POST['edit_username'])) {
//
//                if ($model->editUsername() != null) {
//                    $model = $model->editUsername();
//                } else $model->password = '';
//            } elseif (isset($_POST['edit_profile_info'])) {
//                if ($model->editProfileInfo() != null) {
//                    $model->editProfileInfo();
//                }
//            } elseif (isset($_POST['edit_email'])) {
//                if ($model->editEmail() != null) {
//                    $model->editEmail();
//                } else $model->password = '';
//            } elseif (isset($_POST['edit_password'])) {
//                if ($model->editPassword() != null) {
//                    $model->editPassword();
//                } else $model->password = '';
//            }else $model = User::infoForProfile(Yii::$app->user->id);
//        }else $model = User::infoForProfile(Yii::$app->user->id);
//
////            if ($model->editProfileInfo() != null) {
////                $model->editProfileInfo();
////                return $this->redirect('/profile');
////            }else $model = User::infoForProfile(Yii::$app->user->id);
////        }
////        $model = User::find()->where(["id" => Yii::$app->user->id])->one();
//        return $this->render('edit', [
//            'model' => $model,
//        ]);
//    }

    /**
     * @return array
     */
    public function actionUploadPicture()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new ImageLoader();
        $model->picture = UploadedFile::getInstance($model, "picture");

        if ($model->validate()) {
            $user = User::find()->where(["id" => Yii::$app->user->id])->one();
//            $user = Yii::$app->user->identity;
            $user->avatar = Yii::$app->storage->saveUploadedFile($model->picture, 800, 600);
            // 15/27/30/379e706840f951d22de02458a4788eb55f.jpg

            if ($user->save(false, ['avatar'])) {
                return [
                    'success' => true,
                    'pictureUri' => Yii::$app->storage->getFile($user->avatar),
                ];
            }
        }
        return ['success' => false, 'errors' => $model->getErrors()];
    }
}
