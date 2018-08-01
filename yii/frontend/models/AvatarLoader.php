<?php

namespace frontend\models;

use Yii;
use yii\base\Model;


class AvatarLoader extends Model
{
    public $picture;

    public function rules()
    {
        return [
            [['picture'], 'file',
                'extensions' => 'jpg, gif, png',
                'checkExtensionByMimeType' => true,
            ]
        ];
    }

}