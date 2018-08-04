<?php

/* @var $this yii\web\View */

/* @var $modelAvatar frontend\models\AvatarLoader */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use dosamigos\fileupload\FileUpload;
use frontend\models\Friends;

$this->title = 'Просмотр профиля ' . $user->id;
?>
<div class="site-index">

    <div class="text-center">
        <h1>ПРОФИЛЬ <?= Yii::$app->user->id; ?> смотрит <?= $user->id; ?></h1>

        <h3><?php echo Html::encode($user->username); ?></h3>
        <p><?php echo HtmlPurifier::process($user->about); ?></p>
        <hr>

        <img src="<?= $user->getPicture(); ?>" class="img-rounded" id="profile-picture"/>
<!--        <img src="--><?//= $user->getPicture(); ?><!--" id="profile-picture"/>-->


        <!-- если на своей странице, то показываем кнопки-->
        <?php if (Yii::$app->user->id == $user->id): ?>

            <div class="alert alert-success display-none" id="profile-image-success">Profile image updated</div>
            <div class="alert alert-danger display-none" id="profile-image-fail"></div>


            <?= FileUpload::widget([
                    'model' => $modelAvatar,
                    'attribute' => 'picture',
                    'url' => ['profile/upload-picture'], // your url, this is just for demo purposes,
                    'options' => ['accept' => 'image/*'],
                    'clientOptions' => [
                        'maxFileSize' => 2000000
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


            <a class="btn btn-lg btn-info" href="/profile/edit">Редактировать мой профиль</a>
        <?php endif; ?>

    </div>

    <!--    <a href="-->
    <?php //echo Url::to(['/user/profile/subscribe', 'id' => $user->getId()]); ?><!--" class="btn btn-info">Subscribe</a>-->
    <!--    <a href="-->
    <?php //echo Url::to(['/user/profile/unsubscribe', 'id' => $user->getId()]); ?><!--" class="btn btn-info">Unsubscribe</a>-->

    <hr>



<?php if ($user->id != Yii::$app->user->id):?>
    <?php if (Friends::isSubscribe($user->id)):?>
        <a class="btn btn-lg btn-info" href="/friends/delete-subscribe/follow_id=<?= $user->id; ?>">отписаться</a>
    <?php else: ?>
        <a class="btn btn-lg btn-info" href="/friends/add-subscribe/follow_id=<?= $user->id; ?>">подписаться</a>
    <?php endif;?>
    <hr>
<?php endif;?>



    <h4>подписки и подписчики</h4>
        <a class="btn btn-lg btn-info" href="/friends/subscribe/id=<?= $user->id; ?>">подписки <?= Friends::countSubscribe($user->id);?></a>
        <a class="btn btn-lg btn-info" href="/friends/follower/id=<?= $user->id; ?>">подписчики <?= Friends::countFollower($user->id);?></a>
    <hr>




    <div class="jumbotron">

        <div class="body-content">

            <div class="row">

                <?php foreach ($user as $key => $param): ?>
                    <?= "$key = $param<br>"; ?>
                <?php endforeach; ?>

                <!--                <p>привет --><? //= $user->id ;?><!--</p>-->
                <!--                <p>привет --><? //= $user->username;?><!--</p></div>-->

            </div>
        </div>
    </div>

    <!---->
    <!---->
    <!--    <!-- Button trigger modal -->-->
    <!--    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal1">-->
    <!--        Subscriptions: --><?php //echo $user->countSubscriptions(); ?>
    <!--    </button>-->
    <!---->
    <!--    <!-- Button trigger modal -->-->
    <!--    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal2">-->
    <!--        Followers: --><?php //echo $user->countFollowers(); ?>
    <!--    </button>-->
    <!---->
    <!---->
    <!--    <!-- Modal subscriptions -->-->
    <!--    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
    <!--        <div class="modal-dialog" role="document">-->
    <!--            <div class="modal-content">-->
    <!--                <div class="modal-header">-->
    <!--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
    <!--                    <h4 class="modal-title" id="myModalLabel">Subscriptions</h4>-->
    <!--                </div>-->
    <!--                <div class="modal-body">-->
    <!--                    <div class="row">-->
    <!--                        --><?php //foreach ($user->getSubscriptions() as $subscription): ?>
    <!--                            <div class="col-md-12">-->
    <!--                                <a href="-->
    <?php //echo Url::to(['/user/profile/view', 'nickname' => ($subscription['nickname']) ? $subscription['nickname'] : $subscription['id']]); ?><!--">-->
    <!--                                    --><?php //echo Html::encode($subscription['username']); ?>
    <!--                                </a>-->
    <!--                            </div>-->
    <!--                        --><?php //endforeach; ?>
    <!--                    </div>-->
    <!--                </div>-->
    <!--                <div class="modal-footer">-->
    <!--                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--    <!-- Modal subscriptions -->-->
    <!---->
    <!--    <!-- Modal followers -->-->
    <!--    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
    <!--        <div class="modal-dialog" role="document">-->
    <!--            <div class="modal-content">-->
    <!--                <div class="modal-header">-->
    <!--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
    <!--                    <h4 class="modal-title" id="myModalLabel">Followers</h4>-->
    <!--                </div>-->
    <!--                <div class="modal-body">-->
    <!--                    <div class="row">-->
    <!--                        --><?php //foreach ($user->getFollowers() as $follower): ?>
    <!--                            <div class="col-md-12">-->
    <!--                                <a href="-->
    <?php //echo Url::to(['/user/profile/view', 'nickname' => ($follower['nickname']) ? $follower['nickname'] : $follower['id']]); ?><!--">-->
    <!--                                    --><?php //echo Html::encode($follower['username']); ?>
    <!--                                </a>-->
    <!--                            </div>-->
    <!--                        --><?php //endforeach; ?>
    <!--                    </div>-->
    <!--                </div>-->
    <!--                <div class="modal-footer">-->
    <!--                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--    <!-- Modal followers -->-->