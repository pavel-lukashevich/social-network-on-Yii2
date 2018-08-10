<?php

/* @var $this yii\web\View */
/* @var $modelImage frontend\models\ImageLoader */
/* @var $picture frontend\models\ImageLoader */
/* @var $user frontend\models\Friends */
/* @var $user \common\models\User*/

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use dosamigos\fileupload\FileUpload;
use frontend\models\Friends;

$this->title = 'Просмотр профиля ' . Html::encode($user->username);
?>
<div class="site-index">

    <div class="text-center">
        <h1><?= Html::encode($user->username) ; ?> </h1>
        <br>
    </div>

    <div class="row">
        <div class="col-md-5">
            <center>

                <?php if (Yii::$app->user->id == $user->id): ?>
                    <a class="btn btn-sm btn-default" href="/profile/edit">Редактировать мой профиль</a><br>
                <?php endif; ?>

                <img src="<?= $user->getPicture(); ?>" class="img-rounded"  id="profile-picture"/>

                <p>
                <!-- если на своей странице, то показываем кнопки-->
                <?php if (Yii::$app->user->id == $user->id): ?>
                    <?= FileUpload::widget([
                        'model' => $modelImage,
                        'attribute' => 'picture',
                        'url' => ['profile/upload-picture'], // your url, this is just for demo purposes,
                        'options' => ['accept' => 'image/*'],
                        'clientOptions' => [
    //                        'maxFileSize' => 2000000
                        ],
                        // Also, you can specify jQuery-File-Upload events
                        // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
                        'clientEvents' => [
                            'fileuploaddone' => 'function(e, data) {
                                 if (data.result.success) {
                                    $("#profile-image-success").show();
                                    $("#profile-image-fail").hide();
                                    $("#profile-picture").attr("src", data.result.pictureUri);
                                 } else {
                                    $("#profile-image-fail").html(data.result.errors.picture).show();
                                    $("#profile-image-success").hide();
                                 }
                             }',
                        ],
                    ]); ?>

                <?php endif; ?>

                <div class="alert alert-success display-none" id="profile-image-success">фото успешно обновлено</div>
                <div class="alert alert-danger display-none" id="profile-image-fail"></div>
                </p>

                <?php if ($user->id != Yii::$app->user->id): ?>
                    <?php if (Friends::isSubscribe($user->id)): ?>
                        <a class="btn btn-md btn-default" href="/friends/delete-subscribe/follow_id=<?= $user->id; ?>">отписаться</a>
                    <?php else: ?>
                        <a class="btn btn-md btn-default"
                           href="/friends/add-subscribe/follow_id=<?= $user->id; ?>">подписаться</a>
                    <?php endif; ?>
                <?php endif; ?>

                </center>
        </div>

        <div class="col-md-7">
            <div class="text-center">
                <a class="btn btn-md btn-default"
                   href="/friends/subscribe/id=<?= $user->id; ?>">подписки <?= Friends::countSubscribe($user->id); ?></a>
                &nbsp;
                <a class="btn btn-md btn-default"
                   href="/friends/follower/id=<?= $user->id; ?>">подписчики <?= Friends::countFollower($user->id); ?></a>
                <br><br>
            </div>

            <div class="body-content text-center">

                <h3>информация</h3>

                <div class="row">
                    <div class="col-md-12">
                        <div class="list-user">
                            &nbsp;<?= $user->firstname ? Html::encode($user->firstname) : "<sub>имя</sub>";?>&nbsp;
                            &nbsp;&nbsp;
                            &nbsp;<?= $user->lastname ? Html::encode($user->lastname) : "<sub>фамилия</sub>";?>&nbsp;
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="list-user">
                            <?= $user->country ? Html::encode($user->country) : "<sub>страна</sub>";?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="list-user">&nbsp;
                            <?= $user->city ? Html::encode($user->city) : "<sub>город</sub>";?>
                        </div>

                    </div>
                </div>

<!--                <div class="row">-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="list-user">-->
<!--                            &nbsp;--><?//= $user->birthsday ? $user->birthsday : "<sub>дата рождения</sub>";?><!--&nbsp;-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="list-user">-->
<!--                            &nbsp;--><?//= $user->phone ? $user->phone : "<sub>телефон</sub>";?><!--&nbsp;-->
<!--                        </div>-->
<!---->
<!--                    </div>-->
<!--                </div>-->

                <div class="row">
                    <div class="col-md-12">
                        <div class="list-user">
                            <?= $user->education ? "образование: " . Html::encode($user->education) : "<sub>образование</sub>";?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="list-user">
                            <?= $user->job ? "работа: " . Html::encode($user->job) : "<sub>работа</sub>";?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="list-user">
                            <?= $user->about ? "о себе: " . HtmlPurifier::process($user->about) : "<sub>о себе</sub>";?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

    </div>
</div>
