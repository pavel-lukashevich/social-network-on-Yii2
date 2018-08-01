<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 5],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {

            foreach ($this->imageFiles as $file) {
                if (!file_exists('../../../uploads/')) {
                    mkdir('../../../uploads/');
                }
                $file->saveAs('../../../uploads/' . $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;

        }
    }
}