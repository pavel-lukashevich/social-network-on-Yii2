<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $news_id
 * @property int $user_id
 * @property int $date
 * @property string $comment
 * @property string $like
 * @property string $dislike
 * @property int $status
 * @property int $count_like
 * @property int $count_dislike
 */
class Comment extends \yii\db\ActiveRecord
{
    const COMMENT_FOR_PAGE = 10;
    const TYPE_ALL = 0;
    const TYPE_TEXT = 1;
    const TYPE_HTML = 2;
    const TYPE_IMAGE = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['news_id', 'user_id', 'date', 'comment'], 'required'],
            [['comment'], 'required'],
            [['news_id', 'user_id', 'date', 'status', 'count_like', 'count_dislike'], 'integer'],
            [['like', 'dislike'], 'string'],
            [['comment'], 'string', 'max' => 2000],
        ];
    }

    /**
     * @param $postId
     * @return mixed
     */
    public static function count($postId, $type = self::TYPE_TEXT)
    {
        $countComment = Comment::find()
            ->select(['count(*)'])
            ->where(['news_id' => $postId])
//            ->andWhere(['type' => $type])
            ->asArray()
            ->one();

        return $countComment['count(*)'];
    }

    /**
     * @return bool|null
     */
    public function addComment()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->user_id = Yii::$app->user->id;
        $this->date = time();

        return true;
    }

    /**
     * @param $offset
     * @param $newsId
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getCommentForNews($offset, $newsId)
    {
            $comment = Comment::find()
                ->select(['id', 'news_id', 'user_id', 'date', 'comment', 'count_like', 'count_dislike'])
                ->where(["news_id" => $newsId])
                ->andWhere(['=','status', '10'])
                ->limit(self::COMMENT_FOR_PAGE)
                ->offset($offset)
                ->orderBy(['id' => SORT_DESC])
                ->all();
        return $comment;
    }

    /**
     * @param $comment
     * @return array|User|\yii\db\ActiveRecord[]
     */
    public static function getListUsers($comment)
    {
        if ($comment != null) {
            $user_id = '';
            foreach ($comment as $list) {
                $user_id .= $list->user_id . ",";
            }

            $user_id = trim($user_id, ',');

            $users = User::find()
                ->select(['id', 'username', 'avatar'])
                ->where("id IN($user_id)")
                ->indexBy('id')
                ->all();
            return $users;
        } else return new User();
    }

    /**
     * @param $comment_id
     * @param $user_id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function isRateLike($comment_id, $user_id){

        $comment = self::getLikeDislikeNews($comment_id);
        // получаем массив лайков и дизлайков
        if ($comment->like && $comment->like != 'null') {
            $like = json_decode($comment->like, true);
        };

        if ($comment->dislike && $comment->dislike != 'null') {
            $dislike = json_decode($comment->dislike, true);
        };
        // добавляем одно, и удаляем другое
        $like[$user_id] = 1;
        unset($dislike[$user_id]);

        // считаем колличество и преобразуем json
        $comment->count_like = count($like);
        $comment->count_dislike = count($dislike);
        $comment->like = json_encode($like);
        $comment->dislike = json_encode($dislike);

        return $comment;
    }

    /**
     * @param $news_id
     * @param $user_id
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function isRateDislike($comment_id, $user_id){

        $comment = self::getLikeDislikeNews($comment_id);
        // получаем массив лайков и дизлайков
        if ($comment->like && $comment->like != 'null') {
            $like = json_decode($comment->like, true);
        } else $like = [];

        if ($comment->dislike && $comment->dislike != 'null') {
            $dislike = json_decode($comment->dislike, true);
        } else $dislike = [];
        // добавляем одно, и удаляем другое
        $dislike[$user_id] = 1;
        unset($like[$user_id]);

        // считаем колличество и преобразуем json
        $comment->count_like = count($like);
        $comment->count_dislike = count($dislike);
        $comment->like = json_encode($like);
        $comment->dislike = json_encode($dislike);

        return $comment;
    }

    /**
     * @param $comment_id
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getLikeDislikeNews($comment_id)
    {
        $comment = self::find()
            ->select(['id', 'news_id', 'user_id', 'like', 'dislike', 'count_like', 'count_dislike'])
            ->where(['id' => $comment_id])
            ->one();
        return $comment;
    }

    /**
     * @return bool|null
     */
    public function editComment()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->user_id = Yii::$app->user->id;
        $this->date = time();

        return true;
    }

    /**
     * @param $commentId
     * @param $userId
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function deleteComment($commentId, $userId)
    {
        $comment = self::find()->where(['id' => $commentId])->andWhere(['user_id' => $userId])->one();
        $comment->delete();

        return true;
    }

    /**
     * @param $commentId
     * @return mixed
     */
    public static function getNewsById($commentId)
    {
        $comment = Comment::find()->select('news_id')->where(['id' => $commentId])->one();

        $newsId = $comment->news_id;

        return $newsId;
    }

}
