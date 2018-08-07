<?php

namespace frontend\models;

use yii\base\Model;


class ImageLoader extends Model
{
    public $picture;

    public function rules()
    {
        return [
            [['picture'], 'file',
                'extensions' => 'jpg, png, gif',
                'checkExtensionByMimeType' => true,
            ]
        ];
    }

}