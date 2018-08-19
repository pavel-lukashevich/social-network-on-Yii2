<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Gallery;

/* @var $this yii\web\View */
/* @var $user \common\models\User */
/* @var $modelNews \frontend\models\News */
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
                        <a class="fancyimage" rel="group" href="/gallery/view/img-<?= $img->id;?>">
                            <span class='circle-btn'>comment: <?php  echo ($img->comment_count == 0)  ? 0 : $img->comment_count;?></span>
                        </a>
                        <a class="fancyimage" rel="group" href="/gallery/view/img-<?= $img->id;?>">
                            <img class="img-responsive" src="<?= $img->getPicture();?>" alt="<?=$img->heading ?>" />
                        </a>
                        <div>
                        <?php if ($img->status == Gallery::IMAGE_SHOW): ?>
                            <button type="button" class="btn btn-sm btn-default add-image-news" data-id="<?= $img->user_id;?>" data-toggle="modal" data-target="#addNews">рассказать</button>
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

    <!-- Модальное окно добавление новости -->
    <div class="modal fade" id="addNews" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="text-center">
                        <h4 class="modal-title" id="myModalLabel">добавить новость</h4>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="text-center row">

                        <?php $form = ActiveForm::begin(['id' => 'addNews', 'action' => '/news/create']); ?>

                        <div class="col-sm-12">
                            <?= $form->field($modelNews, 'heading')->textInput(['required' => true,'aria-invalid' => true])->label('заголовок') ?>

                            <?= Html::activeHiddenInput($modelNews, 'type') ?>
                            <?= Html::activeHiddenInput($modelNews, 'tags') ?>
                            <?= Html::activeHiddenInput($modelNews, 'text') ?>
                            <img class="img-responsive" id="image-news" src="">

                            <div class="form-group">
                                <?= Html::submitButton('добавить новость', ['class' => 'btn btn-sm btn-default',]) ?>
                            </div>

                        </div>
                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>




<?php
$this->registerJsFile('/js/likes.js', [
    'depends' => \yii\web\JqueryAsset::className(),
]);
?>