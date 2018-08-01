<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use dosamigos\fileupload\FileUpload;

$this->title = 'друзьяшки';
?>

<h1>друзья пользавателя <?= $userId ?></h1>

<h2>вы подписаны на </h2>
<hr>


<?php foreach ($friends->getSubscribe() as $sub): ?>
    <?php if ($sub != 0): ?>
        <a href="profile/<?= $sub->id; ?>" class="btn">
            <img src="<?= $sub->getPicture(); ?>" class="img-circle" width="60px"/>
            <?= $sub->username; ?>
        </a><br>
        <hr>
    <?php endif; ?>
<?php endforeach; ?>

<h2>на вас подписаны</h2>

<?php foreach ($friends->getFollower() as $fol): ?>
    <?php if ($fol != 0): ?>
        <a href="profile/<?= $fol->id; ?>" class="btn">
            <img src="<?= $fol->getPicture(); ?>" class="img-circle" width="60px"/>
            <?= $fol->username; ?>
        </a><br>
        <hr>
    <?php endif; ?>
<?php endforeach; ?>


<p>
    You may change the content of this page by modifying
    <!--    the file <code>--><? //= __FILE__; ?><!--</code>.-->
</p>
