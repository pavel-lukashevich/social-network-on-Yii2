<?php

/* @var $this yii\web\View */
/* @var $modelImage frontend\models\ImageLoader */
/* @var $picture frontend\models\ImageLoader */
/* @var $user frontend\models\Friends */
/* @var $news frontend\models\News */
/* @var $user \common\models\User*/

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\HtmlPurifier;
use dosamigos\fileupload\FileUpload;
use frontend\models\Friends;
use frontend\models\News;

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

                <div>
                    <!-- если на своей странице, то показываем кнопки-->
                    <?php if (Yii::$app->user->id == $user->id): ?>
                    <?= FileUpload::widget([
                        'model' => $modelImage,
                        'attribute' => 'picture',
                        'url' => ['gallery/upload-avatar',],
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
                </div>

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

            <div class="text-center">
                <a class="btn btn-md btn-default"
                   href="/gallery/index/id=<?= $user->id; ?>">смотреть галерею</a>
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
<!--                            &nbsp;-->
<!--                            --><?php //
//                             echo $user->birthsday ? $user->birthsday : "<sub>дата рождения</sub>";
//                            ?>
<!--                            &nbsp;-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="list-user">-->
<!--                            &nbsp;-->
<!--                            --><?php //
//                                echo $user->phone ? $user->phone : "<sub>телефон</sub>";
//                            ?>
<!--                            &nbsp;-->
<!--                        </div>-->
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
        <div class="text-center">
        <?php if (Yii::$app->user->id == $user->id): ?>
            <div class="list-user">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#addNews">добавить новость</button>
                <br>
                <br>
            </div>
        <?php endif;?>

            <?php foreach ($news as $newsItem): ?>
            <div class="list-user">
                <div class='row'>
                    <div class='col-md-8'>
                        <p>
                            <?php if ($newsItem->status == 0)echo "<div class='circle-btn'>скрыта</div>";?>
                            <a class='btn-link' href='/news/view/post-<?= $newsItem->id;?>'><?= Html::encode($newsItem->heading); ?></a>
                        </p>
                    </div>
                    <div class='col-md-4'>
                        <p>
                            <?= date('d-m-Y / H:i', $newsItem->date); ?>
                        </p>
                    </div>
                </div>
                <div class='row clear'>
                    <div class='col-md-12'>
                        <?php if($newsItem->type == News::TYPE_IMAGE):?>
                            <div  class="fancyimage"><center>
                                    <a href="http://social/gallery/index/id=<?= $newsItem->tags;?>" class="fancyimage">
                                        <img class="img-responsive" src="<?= $newsItem->text;?>" alt="<?= Html::encode($newsItem->heading); ?>">
                                    </a></center>
                            </div>
                        <?php elseif($newsItem->type == News::TYPE_HTML):?>
                            <div class='col-sm-12'>
                                <?= HtmlPurifier::process($newsItem->text); ?>
                            </div>
                        <?php elseif($newsItem->type == News::TYPE_TEXT):?>
                            <div class='user-text news-text'><?= Html::encode($newsItem->text); ?></div>
                        <?php endif;?>

                        <?php if ($newsItem->user_id != Yii::$app->user->id): ?>
                            <a class='btn btn-sm  btn-default button-like' href="#" data-id='<?= $newsItem->id;?>'><span class="like-count"><?= $newsItem->count_like;?></span> + </a>
                            <a class='btn btn-sm  btn-default button-dislike' href="#" data-id='<?= $newsItem->id;?>'> - <span class="dislike-count"><?= $newsItem->count_dislike;?></span></a>
                        <?php else :?>

                            <span class='circle-btn'><?= $newsItem->count_like;?> + </span>
                            <span class='circle-btn'> - <?= $newsItem->count_dislike;?></span>

                            <?php if($newsItem->type != News::TYPE_IMAGE):?>
                                <a class='btn btn-sm btn-default' href='/news/view/post-<?= $newsItem->id;?>'>просмотр и редактирование</a>
                            <?php endif;?>

                            <?php if ($newsItem->status == 10): ?>
                                <a class='btn btn-sm  btn-default' href='/news/hide/n-<?php echo $newsItem->id;?>'>скрыть</a>
                            <?php elseif ($newsItem->status == 0): ?>
                                <a class='btn btn-sm  btn-default' href='/news/show/n-<?php echo $newsItem->id;?>'>показать</a>
                            <?php endif;?>
                            <a class='btn btn-sm  btn-default' href='/news/delete/n-<?php echo $newsItem->id;?>'>удалить</a>

                        <?php endif; ?>
                    </div>
                </div>
             </div>
            <?php endforeach; ?>

            <?php if (!empty($pagin))echo $pagin->get();?>

        </div>
    </div>


    <?php if (Yii::$app->user->id == $user->id): ?>
    <!-- Модальное окно добавление новости-->
    <div class="modal fade" id="addNews" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="text-center">
                        <h4 class="modal-title" id="myModalLabel">добавить новость</h4>

                    </div>
                </div>
                <div class="modal-body">
                    <div class="text-center">

                        <?php $form = ActiveForm::begin(['id' => 'addNews', 'action' => '/news/create']); ?>

                        <?= $form->field($model, 'heading')->textInput()->label('заголовок') ?>
                        <?= $form->field($model, 'tags')->textInput()->label('тэги') ?>
                        <?= $form->field($model, 'text')->label('новость')->textarea(['rows' => '8']) ?>

                        <div class="form-group">
                            <?= Html::submitButton('добавить новость', ['class' => 'btn btn-default',]) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>




</div>


<?php
$this->registerJsFile('/js/likes.js', [
    'depends' => \yii\web\JqueryAsset::className(),
]);
?>