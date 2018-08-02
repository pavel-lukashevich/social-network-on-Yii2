<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use dosamigos\fileupload\FileUpload;

$this->title = 'друзьяшки';
?>

<?php \frontend\components\SudscribeButton::run() ?>

<h2>на вас подписаны</h2>
<hr>

<?php \frontend\components\SudscribeButton::list($friend, 'add') ?>


<p>
    You may change the content of this page by modifying
</p>
