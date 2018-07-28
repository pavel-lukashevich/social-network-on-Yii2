<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead"> Просто 14 записей созданных фейкером</p>

    </div>

    <div class="body-content">

        <div class="row">

            <?php for ($i = 0; $i < 14; $i++): ?>

                <?php if ($i%3 == 0) echo "</div><div class=\"row\">"; ?>
                <div class="col-lg-4">

                    <?php $faker = \Faker\Factory::create('ru_RU'); ?>

                    <h2><?= $faker->firstName . " " . $faker->lastName; ?></h2>

                    <p><?= $faker->email; ?>
                        &nbsp&nbsp&nbsp&nbsp<?= $faker->dateTimeThisCentury->format('Y-m-d'); ?> </p>

                    <p><?= $faker->realText(1000); ?></p>

                    <hr>

                </div>
            <?php endfor; ?>

        </div>

    </div>
</div>
