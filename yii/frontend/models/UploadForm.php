<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;


class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;
    public $description;
//    public $heading;
//    public $tags;


    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 10],
//            [['heading', 'tags'], 'trim'],
        ];
    }

    /**
     * @param $userId
     * @param string $description
     * @return array|bool
     */
    public function upload($userId, $description = '')
    {
        if ($this->validate()) {
            $img = array();
            foreach ($this->imageFiles as $file) {
                $patch = Yii::$app->storage->saveUploadedFile($file, 800, 600);
                $gallery = new Gallery();
//                $img[] = $gallery->addPicture($patch, $userId, $description)
                if ($gallery->addPicture($patch, $userId, $description)){
                    $img[] = $patch;
                }else return false;
            }
            return $img;
        } else {
            return false;
        }
    }

}