<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
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
                <?php if ($div++ % 4 == 0) echo '<div class="row">';?>

                    <div class="col-lg-3">
                        <div>
                            <img src="https://pp.userapi.com/c5100/u120281127/a_7768e20b.jpg" alt="..."
                                 class="center-block img-circle" width="60%">
                            <h2 class="text-center"><?= $show->username ?></h2>
                        </div>
                    </div>

                    <?php if($div % 4 == 0) echo '</div >'; ?>
            <?php endforeach; ?>

        </div>
    </div>
    <div class="text-center">
        <h3>Присоединяйся к нам!</h3>
        <p>
            <a class="btn btn-lg btn-info" href="/site/login">Войти</a>
            <a class="btn btn-lg btn-success" href="site/signup">Зарегистрироваться</a>
        </p>
    </div>

</div>
