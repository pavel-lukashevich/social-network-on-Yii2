<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model \frontend\models\Gallery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Galleries';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="gallery-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Gallery', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="container">
        <div class="row">

        <?php foreach ($model as $img):?>
                <div class="col-md-3 col-sm-4 col-xs-6 thumb">
                    <a class="fancyimage" rel="group" href="<?= $img->getPicture();?>">
                        <img class="img-responsive" src="<?= $img->getPicture();?>" alt="<?=$img->heading ?>" />
                    </a>
                </div>
        <?php endforeach;?>

        </div>
    </div>



</div>
