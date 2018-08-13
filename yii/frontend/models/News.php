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
    const NEWS_FOR_PROFILE = 10;

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
            [['tags', 'preview'], 'string', 'max' => 255],
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
            $countNews = News::find()
                ->select(['count(*)'])
                ->where(['=', 'status', '1'])
                ->asArray()
                ->one();
        }else {
            $countNews = News::find()
                ->select(['count(*)'])
                ->where("user_id IN ($ids)")
                ->andWhere(['=','status', '1'])
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
            $news = News::find()
                ->select(['id', 'user_id', 'date', 'heading', 'preview', 'like', 'dislike'])
                ->where(['=','status', '1'])
                ->limit(News::NEWS_FOR_PAGE)
                ->offset($offset)
                ->orderBy(['id' => SORT_DESC])
                ->all();
        }else {
            $news = News::find()
                ->select(['id', 'user_id', 'date', 'heading', 'preview', 'like', 'dislike'])
                ->where("user_id IN ($ids)")
                ->andWhere(['=', 'status', '1'])
                ->limit(News::NEWS_FOR_PAGE)
                ->offset($offset)
                ->orderBy(['id' => SORT_DESC])
                ->all();
        }
        return $news;
    }

    public static function findFullNews($news_id)
    {
        $news = News::find()
                ->select(['id', 'user_id', 'tags', 'date', 'heading', 'text', 'like', 'dislike'])
                ->where(['id' => $news_id])
                ->andWhere(['status' => '1'])
                ->one();
        return $news;
    }

    public static function getNewsForProfile($offset, $id)
    {
            $news = News::find()
                ->select(['id', 'user_id', 'date', 'heading', 'text', 'like', 'dislike'])
                ->where(['user_id' => $id])
                ->andWhere(['=', 'status', '1'])
                ->limit(News::NEWS_FOR_PROFILE)
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
        $this->preview = substr($this->text, 0,200);
        $this->preview = substr($this->text, 0,strrpos ($this->preview, ' ')) . '...';
        $this->status = 1;

        return true;
    }


    public static function isRateLike($news_id){
        return true;
    }

    public static function isRateDislike($news_id){
        return true;
    }

}
