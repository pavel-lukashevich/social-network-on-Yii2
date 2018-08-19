<?php

/* @var $this yii\web\View */
/* @var $list string */
/* @var $news \frontend\controllers\NewsController */
/* @var $users \common\models\User */
/* @var $modelAdd \frontend\models\UploadForm */

use yii\helpers\Html;
use frontend\models\News;
use yii\bootstrap\ActiveForm;
use yii\helpers\HtmlPurifier;

$this->title = 'Новости';
?>
<div class="news-index">


    <div class="container text-center">
    <h2><?= Html::encode($this->title) ;?></h2>
        <div class="pull-left">
            <a class='btn btn-default <?= ($list == 'all') ? 'active' : '';?>' href = '/news/index' >все</a>
            <a class='btn btn-default <?= ($list == 'friends') ? 'active' : '';?>' href = '/news/friends' >подписки</a>
        </div>
        <div class="pull-right">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#addNews">добавить новость</button>
        </div>
    </div>
<br>



<!--список новостей-->
    <div class="body-content text-center">
        <?php foreach ($news as $newsItem): ?>
            <div class='row list-user'>
                <div class='col-md-4 col-xs-4'>
                    <a href='/profile/<?= $newsItem->user_id; ?>' class='btn'>
                       <p>
                           <img src='<?= $users[$newsItem->user_id]->getPicture(); ?>' class='img-rounded' width='150px'/>
                       </p>
                        <p>
                           <?= Html::encode($users[$newsItem->user_id]['username']); ?>
                        </p>
                    </a>
                </div>
                <div class='col-md-8 col-xs-8'>
                    <div class='row'>
                        <div class='col-md-6'>
                            <p>
                                <a class='btn-link' href='/news/view/post-<?= $newsItem->id;?>'><?= Html::encode($newsItem->heading); ?></a>
                            </p>
                        </div>
                        <div class='col-md-6'>
                            <p>
                                <?= date('d-m-Y / H:i', $newsItem->date); ?>
                            </p>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-12'>
                            <?php if($newsItem->type == News::TYPE_IMAGE):?>
                                <div  class="fancyimage">
                                    <a href="http://social/gallery/index/id=<?= $newsItem->tags;?>" class="fancyimage">
                                        <img class="img-responsive" src="<?= $newsItem->text;?>" alt="<?= Html::encode($newsItem->heading); ?>">
                                    </a>

                                </div>
                            <?php elseif($newsItem->type == News::TYPE_HTML):?>
                                <div class='user-text'>
                                    <?= HtmlPurifier::process($newsItem->text); ?>
                                </div>
                            <?php elseif($newsItem->type == News::TYPE_TEXT):?>
                                <div class='user-text news-text'><?= Html::encode($newsItem->text); ?></div>
                            <?php endif;?>
<!--          like-dislike                  -->
                            <?php if ($newsItem->user_id != Yii::$app->user->id): ?>
                                <a class='btn btn-sm  btn-default button-like' href="#" data-id='<?= $newsItem->id;?>'><span class="like-count"><?= $newsItem->count_like;?></span> + </a>
                                <a class='btn btn-sm  btn-default button-dislike' href="#" data-id='<?= $newsItem->id;?>'> - <span class="dislike-count"><?= $newsItem->count_dislike;?></span></a>
                            <?php else :?>
                                <span class='circle-btn'><?= $newsItem->count_like;?> + </span>
                                <span class='circle-btn'> - <?= $newsItem->count_dislike;?></span>
                            <?php endif; ?>
                            <a class='btn-link' href='/news/view/post-<?= $newsItem->id;?>'>
                                <span class='circle-btn'>всего <?= ($newsItem->comment_count == 0)  ? 0 : $newsItem->comment_count;?> комментариев</span>
                            </a>
<!--            like-dislike-end                -->
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php if (!empty($pagin))echo $pagin->get();?>


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

                            <?= $form->field( $model, 'type' )->radioList( ['1' => 'текст', '2' => 'html',] )->label('формат новости');?>


                            <?= $form->field($model, 'heading')->textInput(['required' => true,'aria-invalid' => true])->label('заголовок') ?>
                            <?= $form->field($model, 'tags')->textInput()->label('тэги') ?>
                            <?= $form->field($model, 'text')->label('новость')->textarea(['rows' => '8']) ?>

                            <div class="form-group">
                                <?= Html::submitButton('добавить новость', ['class' => 'btn btn-default',]) ?>
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