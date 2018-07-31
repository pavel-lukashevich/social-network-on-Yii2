<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="text-center">
        <h1>ПРОФИЛЬ <?= Yii::$app->user->id; ?> смотрит <?= $user->id; ?></h1>

        <?php if (Yii::$app->user->id == $user->id):?>
            <a class="btn btn-lg btn-info" href="/profile/edit">Редактировать мой профиль</a>
        <?php endif;?>
    </div>
    <div class="jumbotron">

        <div class="body-content">

            <div class="row">

                <?php foreach ($user as $key => $param): ?>
                    <?= "$key = $param<br>";?>
                <?php endforeach; ?>

<!--                <p>привет --><?//= $user->id ;?><!--</p>-->
<!--                <p>привет --><?//= $user->username;?><!--</p></div>-->

        </div>
    </div>
</div>
