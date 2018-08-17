<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Gallery;

/* @var $this yii\web\View */
/* @var $user \common\models\User */
/* @var $model \frontend\models\Gallery */
/* @var $modelAdd \frontend\models\UploadForm */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Галерея';
?>

<div class="gallery-index">

    <h3><?= $this->title ;?><a href="/profile/<?= $user->id;?>"> <?= Html::encode($user->username);?></a></h3>
    <div class="container">

        <?php if($user->id == Yii::$app->user->id):?>
        <center><h4>Добавить изображения.</h4></center>
        <div class="row list-user">
            <?php $form = ActiveForm::begin(['action' => '/gallery/upload', 'options' => ['enctype' => 'multipart/form-data']]) ?>

            <div class="col-sm-6">
                <?= $form->field($modelAdd, 'description')->textInput()->label('описание') ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($modelAdd, 'imageFiles[]')->fileInput([
                        'class' => 'btn btn-md btn-block btn-default',
                        'multiple' => true,
                        'accept' => 'image/*'
                ])->label('выберите файлы') ?>
            </div>
            <div class="col-sm-12">
                <button class="btn btn-md btn-block btn-default">Submit</button>
            <br>
            </div>
            <?php ActiveForm::end() ?>
        </div>
        <?php endif;?>

        <div class="row">

        <?php foreach ($model as $img):?>
                <div class="col-md-3 col-sm-4 col-xs-6 thumb <?= $img->status == Gallery::IMAGE_HIDE ? ' hide-thumb' : '';?>">
                    <div class="image-background">
                        <?= date('d-m-Y / H:i', $img->date); ?>
<!--                    счётчик комментов    -->
                        <span class='circle-btn'>comment: <?php // echo ($img->comment_count == 0)  ? 0 : $img->comment_count;?></span>
                        <a class="fancyimage" rel="group" href="/gallery/view/img-<?= $img->id;?>">
                            <img class="img-responsive" src="<?= $img->getPicture();?>" alt="<?=$img->heading ?>" />
                        </a>
                        <div>
                        <?php if ($img->status == Gallery::IMAGE_SHOW): ?>
                            <a class='btn btn-sm  btn-default' href='/new-s/dele-te/n-<?php echo $img->id;?>'>рассказать</a>
                        <?php endif;?>
                        <?php if($user->id != Yii::$app->user->id):?>
                            <a class='btn btn-sm  btn-default button-gal-like' href="#" data-id='<?= $img->id;?>'><span class="like-count"><?= $img->count_like;?></span> + </a>
                            <a class='btn btn-sm  btn-default button-gal-dislike' href="#" data-id='<?= $img->id;?>'> - <span class="dislike-count"><?= $img->count_dislike;?></span></a>
                        <?php else :?>

                            <span class='circle-btn'><?= $img->count_like;?> + </span>
                            <span class='circle-btn'> - <?= $img->count_dislike;?></span>
                        </div>
                        <div>
                            <?php if ($img->status == Gallery::IMAGE_SHOW): ?>
                                <a class='btn btn-sm  btn-default' href='/gallery/hide/n-<?php echo $img->id;?>'>скрыть</a>
                            <?php elseif ($img->status == 0): ?>
                                <a class='btn btn-sm  btn-default' href='/gallery/show/n-<?php echo $img->id;?>'>показать</a>
                            <?php endif;?>

                            <a class='btn btn-sm  btn-default' href='/gallery/delete/n-<?php echo $img->id;?>'>удалить</a>
                        <?php endif;?>
                        </div>
                    </div>
                </div>
        <?php endforeach;?>

        </div>
        <?php if (!empty($pagin))echo $pagin->get();?>
    </div>



</div>


<?php
$this->registerJsFile('/js/likes.js', [
    'depends' => \yii\web\JqueryAsset::className(),
]);
?>