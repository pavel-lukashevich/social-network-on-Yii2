<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="text-center">

        <h3>ищи знакомых, добавляй в подписки!</h3>
        <p class="lead">Нас <?= $count ?> человек.</p>
    </div>
    <div class="jumbotron">
    <?php echo $pagin->get();?>

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
    <?php echo $pagin->get();?>
    </div>


    <div class="text-center">
        <h3>Присоединяйся к нам!</h3>
<!--        <p>-->
<!--            <a class="btn btn-lg btn-info" href="/site/login">Войти</a>-->
<!--            <a class="btn btn-lg btn-success" href="/site/signup">Зарегистрироваться</a>-->
<!--        </p>-->
    </div>

</div>
