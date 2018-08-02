<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use dosamigos\fileupload\FileUpload;

$this->title = 'друзьяшки';
?>

<div class="body-content">

    <!--<h1>друзья пользавателя --><? //= $userId ?><!--</h1>-->
    <?php \frontend\components\SudscribeButton::run() ?>

    <h2>вы подписаны на </h2>
    <hr>

    <?php \frontend\components\SudscribeButton::list($friend, 'delete') ?>

    <br>
    <br>
    <p>
        You may change the content of this page by modifying
    </p>
</div>