<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use dosamigos\fileupload\FileUpload;

$this->title = 'друзьяшки';
?>

<div class="body-content">

    <!--<h1>друзья пользавателя --><? //= $userId ?><!--</h1>-->
    <?php \frontend\components\SudscribeButton::run(Yii::$app->user->id, $userId) ?>

<!--    <h2>вы подписаны на </h2>-->
    <hr>
<!--    --><?php //if (!empty($pagin))echo $pagin->get();?>

    <?php \frontend\components\SudscribeButton::list($friend) ?>

    <?php if (!empty($pagin))echo $pagin->get();?>

<!--    <br>-->
<!--    <br>-->
<!--    <p>-->
<!--        You may change the content of this page by modifying-->
<!--    </p>-->
</div>