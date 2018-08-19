<?php

namespace frontend\controllers;

use frontend\models\Gallery;
use Yii;
use frontend\models\Comment;
use frontend\models\News;
use yii\web\Controller;
use yii\web\Response;


class CommentController extends Controller
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
     * @return Response
     */
    public function actionAdd()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        $comment = new Comment();
        if ($comment->load(Yii::$app->request->post(), 'Comment')) {

            if ($comment->addComment() && $comment->save()){
                if ($comment->status == Comment::COMMENT_NEWS) {
                    $countComment = Comment::count($comment->news_id);
                    News::updateCommentCount($comment->news_id, $countComment);
                }elseif ($comment->status == Comment::COMMENT_IMAGE) {
                    $countComment = Comment::count($comment->news_id, $comment->status);
                    Gallery::updateCommentCount($comment->news_id, $countComment);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->refresh();
    }


    /**
     * @return array|Response
     */
    public function actionLike()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        $commentId = Yii::$app->request->post('id');
        $models = new Comment();
        $model = $models->isRateLike($commentId, Yii::$app->user->id);

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

        $commentId = Yii::$app->request->post('id');
        $models = new Comment();
        $model = $models->isRateDislike($commentId, Yii::$app->user->id);

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


    /***
     * @return Response
     */
    public function actionEdit()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        $model = Comment::findOne(Yii::$app->request->post()['Comment']['id']);

        if ($model->load(Yii::$app->request->post(), 'Comment')) {
            if ($model->editComment() && $model->save()){
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->redirect(['/news']);
    }


    /**
     * @param $commentId
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($commentId)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }
        $news_id = Comment::getNewsById($commentId);

//        var_dump($news_id); die;
        Comment::deleteComment($commentId, Yii::$app->user->id);
        $countComment = Comment::count($news_id);
        News::updateCommentCount($news_id, $countComment);

        return $this->redirect(Yii::$app->request->referrer);
    }

}
