<?php
/* @var $this yii\web\View */
/* @var $userId common\models\User */
/* @var $friend frontend\models\Friends */
/* @var $pagin \common\models\Pagination */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use dosamigos\fileupload\FileUpload;
use frontend\models\Friends;

$this->title = 'друзьяшки';
?>

<div class="body-content">

    <?php \frontend\components\SudscribeButton::run(Yii::$app->user->id, $userId); ?>

    <div class='center-block'>
        <?php foreach ($friend as $sub): ?>
            <?php $div = empty($div) ? 0 : $div; ?>
            <?php if ($div++ % 2 == 0) echo "<div class='row'>"; ?>
            <div class='col-sm-6'>
                <div class='row list-user'>
                    <div class='col-md-4 col-xs-4'>
                        <a href='/profile/<?= $sub->id; ?>' class='btn'>
                            <img src='<?= $sub->getPicture(); ?>' class='img-rounded' width='70px'/>
                        </a>
                    </div>
                    <div class='col-md-8 col-xs-8'>
                        <p>
                            <a href='/profile/<?= $sub->id; ?>' class='btn'><?= Html::encode($sub->username); ?></a>
                        </p>
                        <p>
                            <?php if ($sub->id != Yii::$app->user->id): ?>

                                <?php if (Friends::isSubscribe($sub->id)): ?>
                                    <a class='btn btn-sm  btn-default' href='/friends/delete-subscribe/follow_id=<?= $sub->id;?>'> отписаться</a>
                                <?php else: ?>
                                    <a class='btn btn-sm  btn-default' href='/friends/add-subscribe/follow_id=<?= $sub->id;?>'>подписаться</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php if ($div % 2 == 0 || $div == count($friend)) echo '</div >'; ?>
        <?php endforeach; ?>
    </div>

    <?php if (!empty($pagin))echo $pagin->get();?>

</div>