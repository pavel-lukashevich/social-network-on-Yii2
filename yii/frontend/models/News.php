<?php

namespace frontend\models;

use Yii;

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

    const NEWS_FOR_PAGE = 20;

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
            [['user_id', 'date', 'heading', 'preview', 'text'], 'required'],
            [['user_id', 'date', 'status'], 'integer'],
            [['like', 'dislike'], 'string'],
            [['heading'], 'string', 'max' => 150],
            [['tags', 'preview'], 'string', 'max' => 255],
            [['text'], 'string', 'max' => 5000],
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
//            'preview' => 'Preview',
//            'text' => 'Text',
//            'like' => 'Like',
//            'dislike' => 'Dislike',
//            'status' => 'Status',
//        ];
//    }


}
