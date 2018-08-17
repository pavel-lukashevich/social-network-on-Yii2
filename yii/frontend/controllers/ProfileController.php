<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use frontend\models\EditProfileForm;
use yii\web\Response;
use frontend\models\ImageLoader;
use frontend\models\News;
use common\models\Pagination;

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
    public function actionIndex($userId = null, $pageNum = 1 )
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

        $offset = News::NEWS_FOR_PROFILE * ($pageNum - 1);

        if ($userId == Yii::$app->user->id) {
            $news = News::getAllNewsForProfile($offset, $userId);
        }else {
            $news = News::getNewsForProfile($offset, $userId);
        }
        $count = News::count($userId);
        $pagin = new Pagination($pageNum, $count, News::NEWS_FOR_PROFILE);
        $model = new News();

        return $this->render('index', [
            'user' => $user,
            'modelImage' => $modelImage,
            'model' => $model,
            'news' => $news,
            'pagin' => $pagin,
        ]);
    }

    /**
     * @return string|Response
     */
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
        }else $model = User::infoForProfile(Yii::$app->user->id);

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

}
