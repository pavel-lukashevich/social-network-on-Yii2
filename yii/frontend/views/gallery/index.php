<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model \frontend\models\Gallery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'галерея';
?>

<div class="gallery-index">

    <h1><?= Html::encode($this->title) ?></h1>

   <!-- если на своей странице, то показываем кнопки-->
<!--    --><?php //if (Yii::$app->user->id == $user->id): ?>
<!--    --><?//= FileUpload::widget([
//        'model' => $modelImage,
//        'attribute' => 'picture',
//        'url' => ['profile/upload-picture'], // your url, this is just for demo purposes,
//        'options' => ['accept' => 'image/*'],
//        'clientOptions' => [
//            //                        'maxFileSize' => 2000000
//        ],
//        // Also, you can specify jQuery-File-Upload events
//        // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
//        'clientEvents' => [
//            'fileuploaddone' => 'function(e, data) {
//                                 if (data.result.success) {
//                                    $("#profile-image-success").show();
//                                    $("#profile-image-fail").hide();
//                                    $("#profile-picture").attr("src", data.result.pictureUri);
//                                 } else {
//                                    $("#profile-image-fail").html(data.result.errors.picture).show();
//                                    $("#profile-image-success").hide();
//                                 }
//                             }',
//        ],
//    ]); ?>
<!--    --><?php //endif; ?>
<!--    -->
    <p>
        <?= Html::a('Create Gallery', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="container">
        <div class="row">

        <?php foreach ($model as $img):?>
                <div class="col-md-3 col-sm-4 col-xs-6 thumb">
                    <a class="fancyimage" rel="group" href="<?= $img->getPicture();?>">
                        <img class="img-responsive" src="<?= $img->getPicture();?>" alt="<?=$img->heading ?>" />
                    </a>
<!--                    муляж кнопок-->
                    <div class="btn btn-sm btn-default">like</div>
                    <div class="btn btn-sm btn-default">dislike</div>
                    <div class="btn btn-sm btn-default">удалить</div>
                    <div class="btn btn-sm btn-default">рассказать</div>
                </div>
        <?php endforeach;?>

        </div>
    </div>



</div>
