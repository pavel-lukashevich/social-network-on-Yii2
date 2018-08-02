<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="text-center">
        <a class="btn btn-lg btn-info" href="/friends/all/">Все пользатели</a>
        <a class="btn btn-lg btn-info" href="/friends/subscribe/">я подписан</a>
        <a class="btn btn-lg btn-info" href="/friends/follower/">на меня подписаны</a>
        <a class="btn btn-lg btn-info" href="/friends/mutuality/">взаимные подписки</a>

        <br>
        <br>
        <p class="lead">Нас <?= $count ?> человек.</p>
        <?php echo $pagin->get();?>

    </div>
    <div class="jumbotron">


        <div class="body-content">
            <?php foreach ($user as $show): ?>
                <?php $div = empty($div) ? 0 : $div; ?>

                <?php if ($div++ % 3 == 0) echo '<div class="row">'; ?>

                <div class="col-sm-4">
                    <div class="container__wrapper">
                        <div class="container__content">
                            <a href="/profile/<?= $show->id; ?>" >
                                <img src="<?= $show->getPicture(); ?>" class="img-circle" width="60%"/>
                                <h4 class="text-center"><?= $show->username ?></h4>
                            </a>
                        </div>
                    </div>
                </div>

                <?php if ($div % 3 == 0 || $div == count($user)) echo '</div >'; ?>
            <?php endforeach; ?>


        </div>
        <h3>Присоединяйся к нам!</h3>
    <?php echo $pagin->get();?>
    </div>

</div>
