<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use dosamigos\fileupload\FileUpload;

$this->title = 'друзьяшки';
?>

<!--<h1>друзья пользавателя --><?//= $userId ?><!--</h1>-->

<a class="btn btn-lg btn-info" href="/friends/all">Все пользатели</a>
<a class="btn btn-lg btn-info" href="/friends">я подписан</a>
<a class="btn btn-lg btn-info" href="/friends/follower">на меня подписаны</a>
<a class="btn btn-lg btn-info" href="/friends/mutuality">взаимные подписки</a>


<h2>на вас подписаны</h2>

<?php foreach ($friend as $fol): ?>
    <?php if ($fol != 0): ?>
        <a href="/profile/<?= $fol->id; ?>" class="btn">
            <img src="<?= $fol->getPicture(); ?>" class="img-circle" width="60px"/>
            <?= $fol->username; ?>
            <a class="btn btn-lg btn-info" href="/friends/delete-subscribe/follow_id=<?= $sub->id; ?>">отписаться</a>
        </a><br>
        <hr>
    <?php endif; ?>
<?php endforeach; ?>


<p>
    You may change the content of this page by modifying
</p>
