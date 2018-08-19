<?php

namespace frontend\controllers;

use frontend\models\Comment;
use common\models\User;
use frontend\models\Friends;
use Yii;
use frontend\models\News;
use common\models\Pagination;
use yii\web\Controller;
use yii\web\Response;
use frontend\models\UploadForm;


class NewsController extends Controller
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
     * @param null $typeList
     * @return string|Response
     */
    public function actionIndex($pageNum = 1, $typeList = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        $offset = News::NEWS_FOR_PAGE * ($pageNum - 1);

        $friends = null;

        if ($typeList == 'friends') {
            $friends = Friends::find()->select('subscribe')->where(["user_id" => Yii::$app->user->id])->one();
        }

        $users_id = null;

        if ($friends != null && $friends->getMySubscribersList() != null) {

            $listFriends = $friends->getMySubscribersList();

            $users_id = implode(',', array_keys($listFriends));

        }else $typeList = 'all';

        $modelAdd = new UploadForm();

        $count = News::count($users_id);

        $news = News::findNews($offset, $users_id);

        $users = News::getListUsers($news);

        $pagin = new Pagination($pageNum, $count, News::NEWS_FOR_PAGE);

        $model = new News();
        return $this->render('index', [
            'list' => $typeList,
            'news' => $news,
            'users' => $users,
            'pagin' => $pagin,
            'model' => $model,
            'modelAdd' => $modelAdd,
        ]);

    }

    /**
     * @param $postId
     * @param int $pageNum
     * @return string|Response
     */
    public function actionView($postId, $pageNum = 1)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        $model = News::findFullNews($postId);
        if (!$model || $model == 'null') return $this->redirect('/news');

        if ($model->status == 10 || $model->user_id == Yii::$app->user->id){
            $user = User::find()->select(['id', 'username', 'avatar'])->where(['id' => $model->user_id])->one();
        }else return $this->redirect('/news');

//данные для формы комментов
        $formComment = new Comment();
        $formComment->news_id = $postId;
        $formComment->user_id = Yii::$app->user->id;

        $count = Comment::count($postId);
        if($count == 0) {
            return $this->render('view', [
                'model' => $model,
                'user' => $user,
                'commentCount' => $count,
                'formComment' => $formComment,
            ]);
        }

//получаем комменты
        $offset = Comment::COMMENT_FOR_PAGE * ($pageNum - 1);
        $modelComment = Comment::getCommentForNews($offset, $postId);
        $pagin = new Pagination($pageNum, $count, Comment::COMMENT_FOR_PAGE);
        $users = Comment::getListUsers($modelComment);

        return $this->render('view', [
            'model' => $model,
            'user' => $user,
            'commentCount' => $count,
            'formComment' => $formComment,
            'modelComment' => $modelComment,
            'pagin' => $pagin,
            'users' => $users,
        ]);

    }

    /**
     * @return Response
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        $model = new News();

        if ($model->load(Yii::$app->request->post(), 'News')) {
            if ($model->addNews() && $model->save()){
                return $this->refresh();
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @return array|Response
     */
    public function actionLike()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        $postId = Yii::$app->request->post('id');
        $models = new News();
        $model = $models->isRateLike($postId, Yii::$app->user->id);

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

        $postId = Yii::$app->request->post('id');
        $models = new News();
        $model = $models->isRateDislike($postId, Yii::$app->user->id);

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
     * @return Response
     */
    public function actionEdit()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        $model = News::findOne(Yii::$app->request->post()['News']['id']);

        if ($model->load(Yii::$app->request->post(), 'News')) {
            if ($model->editNews() && $model->save()){
             return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->redirect(['/news']);
    }


    /**
     * @param $postId
     * @return Response
     */
    public function actionShow($postId)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }
        if (News::showNews($postId, Yii::$app->user->id)){
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->redirect(['/news']);
    }

    /**
     * @param $postId
     * @return Response
     */
    public function actionHide($postId)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }
        if (News::hideNews($postId, Yii::$app->user->id)){
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->redirect(['/news']);
    }

    /**
     * @param $postId
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($postId)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }
        if (News::deleteNews($postId, Yii::$app->user->id)){
            return $this->redirect(['/profile']);
        }

        return $this->redirect(['/news']);
    }

}
