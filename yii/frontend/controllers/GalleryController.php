<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\Comment;
use frontend\models\ImageLoader;
use frontend\models\News;
use frontend\models\UploadForm;
use Yii;
use frontend\models\Gallery;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use common\models\Pagination;


class GalleryController extends Controller
{
    /**
     * {@inheritdoc}
     */
//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//        ];
//    }

    /**
     * @param int $pageNum
     * @param null $userId
     * @return string|Response
     */
    public function actionIndex($pageNum = 1, $userId = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }
        $modelAdd = new UploadForm();

        $modelImage = new ImageLoader();

        $userId = ($userId !== null) ? $userId : Yii::$app->user->id;
        $user = User::find()->where(['id' => $userId])->one();

        $offset = Gallery::IMAGE_FOR_PAGE * ($pageNum - 1);
        if ($userId == Yii::$app->user->id){
            $model = Gallery::findImg($offset, $userId, Gallery::IMAGE_HIDE);
        } else {
            $model = Gallery::findImg($offset, $userId, Gallery::IMAGE_SHOW);
        }

        $status = ($userId == Yii::$app->user->id) ? Gallery::IMAGE_HIDE : Gallery::IMAGE_SHOW;
        $count = Gallery::count($userId, $status);
        $pagin = new Pagination($pageNum, $count, Gallery::IMAGE_FOR_PAGE);

        $modelNews = new News();
        $modelNews->type = News::TYPE_IMAGE;


        return $this->render('index', [
            'user' => $user,
            'model' => $model,
            'modelImage' => $modelImage,
            'modelAdd' => $modelAdd,
            'modelNews' => $modelNews,
            'pagin' => $pagin,
        ]);
    }

    /**
     * @param $imgId
     * @param int $pageNum
     * @return string|Response
     */
    public function actionView($imgId, $pageNum = 1 )
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        $model = Gallery::findOneImg($imgId);
        if (!$model || $model == 'null') {
            return $this->redirect('/gallery');
        }

        if ($model->status == Gallery::IMAGE_SHOW || $model->user_id == Yii::$app->user->id){
            $user = User::find()->select(['id', 'username', 'avatar'])->where(['id' => $model->user_id])->one();
        }else return $this->redirect('/news');

//данные для формы комментов
        $formComment = new Comment();
        $formComment->news_id = $imgId;
        $formComment->user_id = Yii::$app->user->id;
        $formComment->status = Comment::COMMENT_IMAGE;

        $modelNews = new News();
        $modelNews->type = News::TYPE_IMAGE;
        $modelNews->tags = $model->user_id;
        $modelNews->text = $model->getPicture();

        $count = Comment::count($imgId, Comment::COMMENT_IMAGE);
        if($count == 0) {
            return $this->render('/gallery/view', [
                'model' => $model,
                'user' => $user,
                'commentCount' => $count,
                'formComment' => $formComment,
                'modelNews' => $modelNews,
            ]);
        }
        //получаем комменты
        $offset = Comment::COMMENT_FOR_PAGE * ($pageNum - 1);
        $modelComment = Comment::getCommentForNews($offset, $imgId, Comment::COMMENT_IMAGE);
        $pagin = new Pagination($pageNum, $count, Comment::COMMENT_FOR_PAGE);
        $users = Comment::getListUsers($modelComment);

        return $this->render('/gallery/view', [
            'model' => $model,
            'user' => $user,
            'commentCount' => $count,
            'formComment' => $formComment,
            'modelComment' => $modelComment,
            'pagin' => $pagin,
            'users' => $users,
            'modelNews' => $modelNews,
        ]);
    }

    /**
     * @return array|Response
     */
    public function actionLike()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        $imgId = Yii::$app->request->post('id');
        $models = new Gallery();
        $model = $models->isRateLike($imgId, Yii::$app->user->id);

        Yii::$app->response->format = Response::FORMAT_JSON;
        if($model->save(false)) {
            return [
                'success' => true,
                'likeCount' => $model->count_like,
                'dislikeCount' => $model->count_dislike,
            ];
        }

        return [
            'success' => false,
        ];
    }

    /**
     * @return array|Response
     */
    public function actionDislike()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        $imgId = Yii::$app->request->post('id');
        $models = new Gallery();
        $model = $models->isRateDislike($imgId, Yii::$app->user->id);

        Yii::$app->response->format = Response::FORMAT_JSON;
        if($model->save(false)) {
            return [
                'success' => true,
                'likeCount' => $model->count_like,
                'dislikeCount' => $model->count_dislike,
            ];
        }

        return [
            'success' => false,
        ];
    }

    /**
     * @param $imgId
     * @return Response
     */
    public function actionShow($imgId)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }
        if (Gallery::showImg($imgId, Yii::$app->user->id)){
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->redirect(['/gallery']);
    }


    /**
     * @param $imgId
     * @return Response
     */
    public function actionHide($imgId)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }
        if (Gallery::hideImg($imgId, Yii::$app->user->id)){
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->redirect(['/gallery']);
    }


    /**
     * @param $postId
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($imgId)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }
        if (Gallery::deleteImage($imgId, Yii::$app->user->id)){
            return $this->redirect(['/gallery']);
        }

        return $this->redirect(['/profile']);
    }

    /**
     * @return Response
     */
    public function actionUpload()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        $modelAdd = new UploadForm();
        if (Yii::$app->request->isPost) {
            $modelAdd->imageFiles = UploadedFile::getInstances($modelAdd, 'imageFiles');
            if ($modelAdd->upload(Yii::$app->user->id, Yii::$app->request->post()['UploadForm']['description'])) {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        return $this->redirect('/gallery/index');
    }


    /**
     * @return array|Response
     */
    public function actionUploadAvatar()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new ImageLoader();
        $model->picture = UploadedFile::getInstance($model, "picture");

        if ($model->validate()) {
            $user = User::find()->where(["id" => Yii::$app->user->id])->one();
            $user->avatar = Yii::$app->storage->saveUploadedFile($model->picture, 800, 600);
            // 15/27/30/379e706840f951d22de02458a4788eb55f.jpg

            //добавляем в таблицу галереи
            $gallery = new Gallery();
            if ($user->save(false, ['avatar']) && $gallery->addPicture($user->avatar, $user->id, 'avatar')) {
                return [
                    'success' => true,
                    'pictureUri' => Yii::$app->storage->getFile($user->avatar),
                ];
            }
        }
        return ['success' => false, 'errors' => $model->getErrors()];
    }

}
