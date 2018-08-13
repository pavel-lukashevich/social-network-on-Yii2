<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\Friends;
use Yii;
use frontend\models\News;
use yii\data\ActiveDataProvider;
use common\models\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * @param int $pageNum
     * @return string|\yii\web\Response
     */
    public function actionIndex($pageNum = 1, $typeList = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }

        $offset = News::NEWS_FOR_PAGE * ($pageNum - 1);

//       $list = Yii::$app->request->get();

        $friends = null;

        if ($typeList == 'friends') {
            $friends = Friends::find()->select('subscribe')->where(["user_id" => Yii::$app->user->id])->one();
        }

        $users_id = null;

        if ($friends != null && $friends->getMySubscribersList() != null) {

//            $listBtn = $list['list'];

            $listFriends = $friends->getMySubscribersList();

            $users_id = implode(',', array_keys($listFriends));

        }else $typeList = 'all';

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
        ]);

    }

    /**
     * @param $postId
     * @return string
     */
    public function actionView($postId)
    {
        $model = News::findFullNews($postId);
        $user = User::find()->select(['id', 'username', 'avatar'])->where(['id' => $model->user_id])->one();
        return $this->render('view', [
            'model' => $model,
            'user' => $user,
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();

        if ($model->load(Yii::$app->request->post(), 'News')) {
//            if ($model->addNews()){
            if ($model->addNews() && $model->save()){
//                        var_dump($this); die;
                return $this->refresh();
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
