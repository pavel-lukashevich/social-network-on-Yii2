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
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex($pageNum = 1)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site');
        }
        $friends = Friends::find()->select('subscribe')->where(["user_id" => Yii::$app->user->id])->one();
        $listFriends = $friends->getMySubscribersList();

        $offset = News::NEWS_FOR_PAGE * ($pageNum - 1);


        ////////////////////////////////////
        /// перенести в модель,
        /// мои подписки
        /// ///////////////////////////////
        if ($listFriends != null) {
            $users_id = implode(',', array_keys($listFriends));

            $countNews = News::find()
                ->select(['count(*)'])
                ->where("user_id IN ($users_id)")
                ->andWhere(['=','status', '1'])
                ->asArray()
                ->one();
            $count = $countNews['count(*)'];

            $news = News::find()
                ->select(['id', 'user_id', 'date', 'heading', 'preview', 'like', 'dislike'])
                ->where("user_id IN ($users_id)")
                ->andWhere(['=','status', '1'])
                ->limit(News::NEWS_FOR_PAGE)
                ->offset($offset)
                ->orderBy(['id' => SORT_DESC])
                ->all();

//            echo "<pre>";var_dump($news == null); die;
            if ($news != null) {
                $user_id = '';
                foreach ($news as $list) {
                    $user_id .= $list->user_id . ",";
                }
                $user_id = trim($user_id, ',');

                $users = User::find()
                    ->select(['id', 'username', 'avatar'])
                    ->where("id IN($user_id)")
                    ->indexBy('id')
                    ->all();
            }

        }else {
            ////////////////////////////////////
            /// перенести в модель,
            /// все новости
            /// ///////////////////////////////

            // счётчик
            $countNews = News::find()
                ->select(['count(*)'])
                ->where(['=','status', '1'])
                ->asArray()
                ->one();
            $count = $countNews['count(*)'];

            // получение новостей
            $news = News::find()
                ->select(['id', 'user_id', 'date', 'heading', 'preview', 'like', 'dislike'])
                ->where(['=','status', '1'])
                ->limit(News::NEWS_FOR_PAGE)
                ->offset($offset)
                ->orderBy(['id' => SORT_DESC])
                ->all();
            // получить список юзеров
            $user_id = '';
            foreach ($news as $list){
                $user_id .= $list->user_id . ",";
            }
            $user_id = rtrim($user_id, ',');

            // инфо о юзерах
            $users = User::find()
                ->select(['id', 'username', 'avatar'])
                ->where("id IN($user_id)")
                ->indexBy('id')
                ->all();

        }

        $pagin = new Pagination($pageNum, $count, News::NEWS_FOR_PAGE);

        return $this->render('index', [
            'news' => $news,
            'users' => $users,
            'pagin' => $pagin,
        ]);

        //////////////////////////////////////////////////
        ///             остатки индекса  из gii      //////
        //////////////////////////////////////////////////
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => News::find(),
//        ]);
//
//        return $this->render('index', [
//            'dataProvider' => $dataProvider,
//        ]);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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
