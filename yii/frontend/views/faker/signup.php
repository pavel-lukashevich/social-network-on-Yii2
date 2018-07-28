<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>
<?php /*
        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
   */?>
    </div>

    <div class="body-content">

        <div class="row">

            <?= 'в БД добавлено ' . $strfaker . ' записей' ?>
            <hr>
            <p> всего в базе <?= $countId?> записей</p>

        </div>

    </div>
</div>
