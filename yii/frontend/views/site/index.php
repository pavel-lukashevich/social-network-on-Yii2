<?php

/* @var $this yii\web\View */

$this->title = 'social-3ax-xyz';
?>
<div class="site-index">

    <div class="text-center">
        <h1>Присоединяйся к нам!</h1>
        <p class="lead">Нас <?= $count ?> человек.</p>
    </div>
    <div class="jumbotron">

        <div class="body-content">

            <?php foreach ($user as $show): ?>
                <?php $div = empty($div) ? 0 : $div; ?>
                <?php if ($div++ % 4 == 0) echo '<div class="row">'; ?>

                <div class="col-sm-3">
                    <div class="container__wrapper">
                        <div class="container__content">
                            <img src="<?= $show->getPicture(); ?>" alt="..."
                                 class="center-block img-circle" width="70%">
                        <h4 class="text-center"><?= $show->username ?></h4>
                        </div>
                    </div>
                </div>

                <?php if ($div % 4 == 0 || $div == count($user)) echo '</div >'; ?>
            <?php endforeach; ?>

        </div>
    </div>
    <div class="text-center">
        <h3>Присоединяйся к нам!</h3>
        <p>
            <a class="btn btn-lg btn-default" href="/site/login">Войти</a>
            <a class="btn btn-lg btn-default" href="/site/signup">Зарегистрироваться</a>
        </p>
    </div>

</div>
