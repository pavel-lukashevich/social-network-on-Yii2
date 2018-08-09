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

        $users_id = implode(',', array_keys($listFriends));

        $users = User::find()
            ->select(['id', 'username', 'avatar'])
            ->where("id IN($users_id)")
            ->indexBy('id')
//            ->asArray()
//            ->limit(Friends::FRIEND_FOR_PAGE)
//            ->offset($offset)
//            ->orderBy(['id' => SORT_DESC])
            ->all();

//        $s_arr = $friends->getSubscribe($offset);
        $news = News::find()
//            ->select(['id', 'user_id', 'date', 'heading', 'preview', 'like', 'dislike'])
//            ->where(['user_id' => $users_id, 'status' => 1])
            ->where("user_id IN ($users_id)")
            ->andWhere(['=','status', '1'])
            ->limit(Friends::FRIEND_FOR_PAGE)
            ->offset($offset)
            ->orderBy(['id' => SORT_DESC])
//            ->asArray()
            ->all();

//        if ($friends == null) {
//            $friends = new Friends();
//        };
//
//        $count = Friends::countSubscribe(Yii::$app->user->id);
//        $pagin = new Pagination($pageNum, $count, Friends::FRIEND_FOR_PAGE);

        return $this->render('index', [
            'news' => $news,
            'users' => $users,
//            'pagin' => $pagin,
        ]);

        //////////////////////////////////////////////////
        //////////////////////////////////////////////////
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
