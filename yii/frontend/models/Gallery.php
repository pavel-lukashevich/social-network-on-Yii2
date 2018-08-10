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
     * @param $avatar
     * @return bool
     */
    public function addPicture($avatar)
    {
        $this->user_id = Yii::$app->user->id;
        $this->date = time();
        $this->heading = 'avatar-' . date('Y-m-d', $this->date);
        $this->tags = 'avatar';
        $this->image = $avatar;
        $this->status = 1;

        if($this->save(false)){
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getPicture()
    {
        if ($this->image !== null) {
            return Yii::$app->storage->getFile($this->image);
        }

        return '';
//        return self::DEFAULT_IMAGE;
    }

}
