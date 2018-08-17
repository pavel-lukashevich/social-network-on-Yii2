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

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 10],
        ];
    }

    /**
     * @param $userId
     * @param string $description
     * @return bool
     */
    public function upload($userId, $description = '')
    {
        if ($this->validate()) {

            foreach ($this->imageFiles as $file) {
                $patch = Yii::$app->storage->saveUploadedFile($file, 800, 600);
                $gallery = new Gallery();
                if (!$gallery->addPicture($patch, $userId, $description)) return false; ;
            }
            return true;
        } else {
            return false;
        }
    }

}