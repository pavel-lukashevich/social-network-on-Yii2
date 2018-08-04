<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="text-center">

        <?php \frontend\components\SudscribeButton::run(Yii::$app->user->id)?>

        <br>
        <br>
        <p class="lead">Нас <?= $count ?> человек.</p>
        <?php echo $pagin->get();?>

    </div>
    <div class="jumbotron">


        <div class="body-content">
            <?php foreach ($user as $show): ?>
                <?php $div = empty($div) ? 0 : $div; ?>

                <?php if ($div++ % 4 == 0) echo '<div class="row">'; ?>

                <div class="col-sm-3">
                    <div class="container__wrapper">
                        <div class="container__content">
                            <a href="/profile/<?= $show->id; ?>" >
                                <img src="<?= $show->getPicture(); ?>" class="img-circle" width="60%"/>
                                <h4 class="text-center"><?= $show->username ?></h4>
                            </a>
                        </div>
                    </div>
                </div>

                <?php if ($div % 4 == 0 || $div == count($user)) echo '</div >'; ?>
            <?php endforeach; ?>


        </div>
        <h3>Присоединяйся к нам!</h3>
    <?php echo $pagin->get();?>
    </div>

</div>
