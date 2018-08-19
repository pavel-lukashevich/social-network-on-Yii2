<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "gallery".
 *
 * @property int $id
 * @property int $user_id
 * @property int $date
 * @property string $heading
 * @property string $tags
 * @property string $image
 * @property string $like
 * @property string $dislike
 * @property int $status
 */
class Gallery extends \yii\db\ActiveRecord
{
    const IMAGE_FOR_PAGE = 24;

    const IMAGE_HIDE = 0;
    const IMAGE_SHOW = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'date', 'heading', 'image'], 'required'],
            [['user_id', 'date', 'status'], 'integer'],
            [['like', 'dislike'], 'string'],
            [['heading'], 'string', 'max' => 150],
            [['tags', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
//    public function attributeLabels()
//    {
//        return [
//            'id' => 'ID',
//            'user_id' => 'User ID',
//            'date' => 'Date',
//            'heading' => 'Heading',
//            'tags' => 'Tags',
//            'image' => 'Image',
//            'like' => 'Like',
//            'dislike' => 'Dislike',
//            'status' => 'Status',
//        ];
//    }


    /**
     * @param $image
     * @param $userId
     * @param string $description
     * @return bool
     */
    public function addPicture($image, $userId, $description = '')
    {

        if (!$this->heading){
            $description = trim($description);
            $description = ($description != '') ? $description : 'image';
            $poz = stripos($description, ' ');
            $poz = $poz == 0 ? strlen($description) : $poz;
            $this->heading = substr($description, 0, $poz) . ' ' . date('Y-m-d', $this->date);
            $this->tags = $description;
        }

        $this->user_id = $userId;
        $this->date = time();
        $this->image = $image;

        if($this->save(false)){
            return true;
        }
        return false;
    }

    /**
     * @param $imgId
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findOneImg($imgId)
    {
        return self::find()->where(['id' => $imgId])->one();
    }

    /**
     * @param $offset
     * @param $userId
     * @param int $status
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findImg($offset, $userId, $status = self::IMAGE_SHOW)
    {
        if ($status == self::IMAGE_HIDE) {
            $img = self::find()
                ->where(['user_id' => $userId])
                ->limit(self::IMAGE_FOR_PAGE)
                ->offset($offset)
                ->orderBy(['id' => SORT_DESC])
                ->all();
        }else {
            $img = self::find()
                ->where(['user_id' => $userId])
                ->andWhere(['status' => $status])
                ->limit(self::IMAGE_FOR_PAGE)
                ->offset($offset)
                ->orderBy(['id' => SORT_DESC])
                ->all();
        }
        return $img;
    }

    /**
     * @param $userId
     * @param int $status
     * @return mixed
     */
    public static function count($userId, $status = self::IMAGE_SHOW)
    {
        if ($status == self::IMAGE_HIDE){
            $count = self::find()
                ->select(['count(*)'])
                ->where(['user_id' => $userId])
                ->asArray()
                ->one();
        }else {
            $count = self::find()
                ->select(['count(*)'])
                ->where(['user_id' => $userId])
                ->andWhere(['status' => $status])
                ->asArray()
                ->one();
        }
        return $count['count(*)'];

    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        if ($this->image !== null) {
            return Yii::$app->storage->getFile($this->image);
        }

        return '';
//        return self::DEFAULT_IMAGE;
    }

    /**
     * @param $imgId
     * @param $userId
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function deleteImage($imgId, $userId)
    {
        $img = self::findImage($imgId, $userId);
        if(file_exists(Yii::getAlias(Yii::$app->params['storagePath']).$img->image)) {
            unlink(Yii::getAlias(Yii::$app->params['storagePath']) . $img->image);
        }
        $img->delete();

        return true;
    }


    /**
     * @param $img_id
     * @param $user_id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function isRateLike($img_id, $user_id)
    {
        $img = self::getLikeDislikeImg($img_id);

        // получаем массив лайков и дизлайков
        $like = $img->getLike();
        $dislike = $img->getDislike();

        // добавляем одно, и удаляем другое
        $like[$user_id] = 1;
        unset($dislike[$user_id]);

        // считаем колличество и преобразуем json
        $img->count_like = count($like);
        $img->count_dislike = count($dislike);
        $img->like = json_encode($like);
        $img->dislike = json_encode($dislike);

        return $img;
    }

    /**
     * @param $img_id
     * @param $user_id
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function isRateDislike($img_id, $user_id){

        $img = self::getLikeDislikeImg($img_id);
        // получаем массив лайков и дизлайков
        $like = $img->getLike();
        $dislike = $img->getDislike();

        // добавляем одно, и удаляем другое
        $dislike[$user_id] = 1;
        unset($like[$user_id]);

        // считаем колличество и преобразуем json
        $img->count_like = count($like);
        $img->count_dislike = count($dislike);
        $img->like = json_encode($like);
        $img->dislike = json_encode($dislike);

        return $img;
    }


    /**
     * @param $img_id
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getLikeDislikeImg($img_id)
    {
        $img = self::find()
            ->select(['id', 'like', 'dislike', 'count_like', 'count_dislike'])
            ->where(['id' => $img_id])
            ->one();
        return $img;
    }

    /**
     * @return array|mixed
     */
    public function getLike()
    {
        if ($this->like && $this->like != 'null') {
            $like = json_decode($this->like, true);
        } else $like = [];
        return $like;
    }

    /**
     * @return array|mixed
     */
    public function getDislike()
    {
         if ($this->dislike && $this->dislike != 'null') {
            $dislike = json_decode($this->dislike, true);
        } else $dislike = [];
        return $dislike;
    }

    /**
     * @param $imgId
     * @param $userId
     * @return bool
     */
    public static function showImg($imgId, $userId)
    {
        $img = self::findImage($imgId, $userId);
        $img->status = self::IMAGE_SHOW;

        $img->save();

        return true;
    }

    /**
     * @param $imgId
     * @param $userId
     * @return bool
     */
    public static function hideImg($imgId, $userId)
    {
        $img = self::findImage($imgId, $userId);
        $img->status = self::IMAGE_HIDE;

        $img->save();

        return true;
    }

    /**
     * @param $imgId
     * @param $userId
     * @return array|bool|null|\yii\db\ActiveRecord
     */
    public static function findImage($imgId, $userId)
    {
        $img = self::find()->where(['id' => $imgId])->andWhere(['user_id' => $userId])->one();
        if($img) {
            return $img;
        }
        return false;

    }

    /**
     * @param $id
     * @param $countComment
     * @return bool
     */
    public static function updateCommentCount($id, $countComment){
        $img = self::find()->where(['id' => $id])->one();
        $img->comment_count = $countComment;
        if ($img->save(false)){
            return true;
        }
        return false;
    }

}
