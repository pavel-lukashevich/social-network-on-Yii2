<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property int $user_id
 * @property int $date
 * @property string $heading
 * @property string $tags
 * @property string $preview
 * @property string $text
 * @property string $like
 * @property string $dislike
 * @property int $status
 */
class News extends \yii\db\ActiveRecord
{
//    public $heading;
//    public $tags;
//    public $text;

    const NEWS_FOR_PAGE = 20;
    const NEWS_FOR_PROFILE = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['heading','text'], 'required'],
//            [['user_id', 'date', 'heading', 'preview', 'text'], 'required'],
            [['user_id', 'date', 'status'], 'integer'],
            [['like', 'dislike'], 'string'],
            [['heading'], 'string', 'max' => 150],
            [['tags'], 'string', 'max' => 255],
            [['text'], 'string', 'max' => 5000],
        ];
    }

    /**
     * @param null $ids
     * @return mixed
     *
     */
    public static function count($ids = null)
    {
        if ($ids == null) {
            $countNews = self::find()
                ->select(['count(*)'])
                ->where(['=', 'status', '10'])
                ->asArray()
                ->one();
        }else {
            $countNews = self::find()
                ->select(['count(*)'])
                ->where("user_id IN ($ids)")
                ->andWhere(['=','status', '10'])
                ->asArray()
                ->one();
        }
            return $countNews['count(*)'];

    }

    /**
     * @param $offset
     * @param null $ids
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findNews($offset, $ids = null)
    {
        if ($ids == null) {
            $news = self::find()
//                ->select(['id', 'user_id', 'date', 'heading', 'text', 'like', 'dislike', 'count_like', 'count_dislike', 'comment_count'])
                ->where(['=','status', '10'])
                ->limit(self::NEWS_FOR_PAGE)
                ->offset($offset)
                ->orderBy(['id' => SORT_DESC])
                ->all();
        }else {
            $news = self::find()
//                ->select(['id', 'user_id', 'date', 'heading', 'text', 'like', 'dislike', 'count_like', 'count_dislike', 'comment_count'])
                ->where("user_id IN ($ids)")
                ->andWhere(['=', 'status', '10'])
                ->limit(self::NEWS_FOR_PAGE)
                ->offset($offset)
                ->orderBy(['id' => SORT_DESC])
                ->all();
        }
        return $news;
    }

    /**
     * @param $news_id
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findFullNews($news_id)
    {
        $news = self::find()
//                ->select(['id', 'user_id', 'tags', 'date', 'heading', 'text', 'like', 'dislike', 'count_like', 'count_dislike', 'status', 'comment_count'])
                ->where(['id' => $news_id])
                ->one();
        return $news;
    }

    /**
     * @param $offset
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAllNewsForProfile($offset, $id)
    {
        $news = self::find()
//            ->select(['id', 'user_id', 'date', 'heading', 'text', 'like', 'dislike', 'count_like', 'count_dislike', 'status'])
            ->where(['user_id' => $id])
            ->limit(self::NEWS_FOR_PROFILE)
            ->offset($offset)
            ->orderBy(['id' => SORT_DESC])
            ->all();
        return $news;
    }

    /**
     * @param $offset
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getNewsForProfile($offset, $id)
    {
            $news = self::find()
//                ->select(['id', 'user_id', 'date', 'heading', 'text', 'like', 'dislike', 'count_like', 'count_dislike', 'status'])
                ->where(['user_id' => $id])
                ->andWhere(['=', 'status', '10'])
                ->limit(self::NEWS_FOR_PROFILE)
                ->offset($offset)
                ->orderBy(['id' => SORT_DESC])
                ->all();
        return $news;
    }

    /**
     * @param $news
     * @return array|User|\yii\db\ActiveRecord[]
     */
    public static function getListUsers($news)
    {
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
            return $users;
        } else return new User();
    }

    /**
     * @return bool|null
     *
     */
    public function addNews()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->user_id = Yii::$app->user->id;
        $this->date = time();
//        $this->preview = substr($this->text, 0,200);
//        $this->preview = substr($this->text, 0,strrpos ($this->preview, ' ')) . '...';
        $this->status = 10;

        return true;
    }

    /**
     * @return bool|null
     */
    public function editNews()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->user_id = Yii::$app->user->id;
        $this->date = time();
//        $this->preview = substr($this->text, 0,200);
//        $this->preview = substr($this->text, 0,strrpos ($this->preview, ' ')) . '...';
        return true;
    }

    /**
     * @param $postId
     * @param $userId
     * @return bool
     */
    public static function showNews($postId, $userId)
    {
        $news = self::find()->where(['id' => $postId])->andWhere(['user_id' => $userId])->one();
        $news->status = 10;

        $news->save();

        return true;
    }

    /**
     * @param $postId
     * @param $userId
     * @return bool
     */
    public static function hideNews($postId, $userId)
    {
        $news = self::find()->where(['id' => $postId])->andWhere(['user_id' => $userId])->one();
        $news->status = 0;

        $news->save();

        return true;
    }

    /**
     * @param $postId
     * @param $userId
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function deleteNews($postId, $userId)
    {
        $news = self::find()->where(['id' => $postId])->andWhere(['user_id' => $userId])->one();
        $news->delete();

        return true;
    }

    /**
     * @param $news_id
     * @param $user_id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function isRateLike($news_id, $user_id){

        $news = self::getLikeDislikeNews($news_id);
        // получаем массив лайков и дизлайков
        if ($news->like && $news->like != 'null') {
            $like = json_decode($news->like, true);
        };

        if ($news->dislike && $news->dislike != 'null') {
            $dislike = json_decode($news->dislike, true);
        };
        // добавляем одно, и удаляем другое
        $like[$user_id] = 1;
        unset($dislike[$user_id]);

        // считаем колличество и преобразуем json
        $news->count_like = count($like);
        $news->count_dislike = count($dislike);
        $news->like = json_encode($like);
        $news->dislike = json_encode($dislike);

        return $news;
    }

    /**
     * @param $news_id
     * @param $user_id
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function isRateDislike($news_id, $user_id){

        $news = self::getLikeDislikeNews($news_id);
        // получаем массив лайков и дизлайков
        if ($news->like && $news->like != 'null') {
            $like = json_decode($news->like, true);
        } else $like = [];

        if ($news->dislike && $news->dislike != 'null') {
            $dislike = json_decode($news->dislike, true);
        } else $dislike = [];
        // добавляем одно, и удаляем другое
        $dislike[$user_id] = 1;
        unset($like[$user_id]);

        // считаем колличество и преобразуем json
        $news->count_like = count($like);
        $news->count_dislike = count($dislike);
        $news->like = json_encode($like);
        $news->dislike = json_encode($dislike);

        return $news;
    }

    /**
     * @param $news_id
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getLikeDislikeNews($news_id)
    {
        $news = self::find()
            ->select(['id', 'like', 'dislike', 'count_like', 'count_dislike'])
            ->where(['id' => $news_id])
            ->one();
        return $news;
    }

    /**
     * @param $news_id
     * @param $countComment
     * @return bool
     */
    public static function updateCommentCount($news_id, $countComment){
        $news = self::find()->where(['id' => $news_id])->one();
        $news->comment_count = $countComment;
        if ($news->save(false)){
            return true;
        }
        return false;
    }

    public static function textOrHtml($string)
    {
        if($string == strip_tags($string)) {
            $string = nl2br($string);
        }
        return $string;
    }

}
