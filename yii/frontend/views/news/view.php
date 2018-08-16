<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\HtmlPurifier;

/* @var $formComment \frontend\models\Comment */
/* @var $modelComment array \frontend\models\Comment */
/* @var $model frontend\models\News */
/* @var $users array \common\models\User */
/* @var $user \common\models\User */
/* @var $commentCount \frontend\controllers\NewsController */

$this->title = Html::encode($model->heading);

?>
<div class="news-view  text-center">

    <h2><?= $this->title; ?></h2>

    <?php if ($model->status == 0)echo "<div class='circle-btn'>скрыта</div>";?>

    <div class='row list-user'>

        <div class='col-md-4 col-xs-4'>
            <a href='/profile/<?= $model->user_id; ?>' class='btn'>
                <p>
                    <img src='<?= $user->getPicture(); ?>' class='img-rounded' width='150px'/>
                </p>
                <p>
                    <?= Html::encode($user->username); ?>
                </p>
            </a>
        </div>
        <div class='col-md-8 col-xs-8'>
            <div class='row'>
                <div class='col-md-8'>
                    <p>
                        <?= Html::encode($model->tags); ?>
                    </p>
                </div>
                <div class='col-md-4'>
                    <p>
                        <?= date('d-m-Y / H:i', $model->date); ?>
                    </p>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-12'>
                    <div  class='row'>
                        <?= HtmlPurifier::process(\frontend\models\News::textOrHtml($model->text)); ?>
                    </div>

                    <!--          like-dislike                  -->
                    <?php if ($model->user_id != Yii::$app->user->id): ?>
                        <a class='btn btn-sm  btn-default button-like' href="#" data-id='<?= $model->id;?>'><span class="like-count"><?= $model->count_like;?></span> + </a>
                        <a class='btn btn-sm  btn-default button-dislike' href="#" data-id='<?= $model->id;?>'> - <span class="dislike-count"><?= $model->count_dislike;?></span></a>
                    <?php else :?>

                        <span class='circle-btn'><?= $model->count_like;?> + </span>
                        <span class='circle-btn'> - <?= $model->count_dislike;?></span>

                        <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#editNews">редактировать</button>
                        <?php if ($model->status == 10): ?>
                            <a class='btn btn-sm  btn-default' href='/news/hide/n-<?php echo $model->id;?>'>скрыть</a>
                        <?php elseif ($model->status == 0): ?>
                            <a class='btn btn-sm  btn-default' href='/news/show/n-<?php echo $model->id;?>'>показать</a>
                        <?php endif;?>
                        <a class='btn btn-sm  btn-default' href='/news/delete/n-<?php echo $model->id;?>'>удалить</a>

                    <?php endif; ?>
                    <!--            like-dislike-end                -->
                </div>
            </div>
        </div>
    </div>



<div  class='container'>
    <a class='btn btn-default pull-left' href = '/news' >перейти к новостям</a>
    <button type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#addComment">добавить комментарий</button>
</div>


<!--    выводим комментарии и инфо о юзерах-->
    <?php if ($commentCount != 0) : ?>
        <p>комментарии:</p>
        <div class='row'>
            <div class='col-md-2 col-xs-0'></div>
                <div class='col-md-8 col-xs-12'>
                    <?php foreach ($modelComment as $comments):?>
                    <div class=' row list-user'>
                        <div class='col-md-9 col-xs-9'>
                            <div class='row'>
                                <div class='col-md-5 col-xs-5 pull-left'><?= date('d-m-Y / H:i', $comments->date); ?></div>
                                <div class='col-md-6 col-xs-6 pull-right'>
                                    <a href='/profile/<?= $comments->user_id; ?>' class='btn'><?= Html::encode($users[$comments->user_id]['username']); ?></a>
                                </div>
                            </div>
                            <div class="comment-text">
                                <?php echo HtmlPurifier::process(\frontend\models\News::textOrHtml($comments->comment)); ?>
                            </div>
                            <!--          like-dislike                  -->
                            <?php if ($comments->user_id != Yii::$app->user->id): ?>
                                <a class='btn btn-sm btn-default button-com-like' href="#" data-id='<?= $comments->id;?>'><span class="like-count"><?= $comments->count_like;?></span> + </a>
                                <a class='btn btn-sm btn-default button-com-dislike' href="#" data-id='<?= $comments->id;?>'> - <span class="dislike-count"><?= $comments->count_dislike;?></span></a>
                            <?php else :?>

                                <span class='circle-btn'><?= $comments->count_like;?> + </span>
                                <span class='circle-btn'> - <?= $comments->count_dislike;?></span>

                                <button type="button" class="btn btn-default btn-sm edit-comment" data-toggle="modal" data-id='<?= $comments->id;?>' data-target="#editComment">редактировать</button>
                                <a class='btn btn-sm  btn-default' href='/comment/delete/n-<?php echo $comments->id;?>'>удалить</a>


                            <?php endif; ?>
                            <!--          like-dislike-end                -->

                        </div>
                        <div class='col-md-3 col-xs-3'>
                        <a href='/profile/<?= $comments->user_id; ?>' class='btn'>
                            <p>
                                <img src='<?= $users[$comments->user_id]->getPicture(); ?>' class='img-rounded' width='100px'/>
                            </p>
                        </a>
                    </div>
                    </div>
                    <?php endforeach; ?>
                </div>
             <div class='col-md-2 col-xs-0'></div>
        </div>

        <?php if (!empty($pagin))echo $pagin->get();?>
    <?php else:?>
        <p>у новости нет комментариев</p>
    <?php endif; ?>


</div>

    <!-- Модальное окно редактирование новости-->
    <div class="modal fade" id="editNews" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                    <div class="text-center">

                        <?php $form = ActiveForm::begin(['id' => 'editNews', 'action' => '/news/edit']); ?>

                        <?= Html::activeHiddenInput($model, 'id') ?>
                        <?= $form->field($model, 'heading')->textInput()->label('заголовок') ?>
                        <?= $form->field($model, 'tags')->textInput()->label('тэги') ?>
                        <?= $form->field($model, 'text')->label('новость')->textarea(['rows' => '8']) ?>

                        <div class="form-group">
                            <?= Html::submitButton('редактировать', ['class' => 'btn btn-default',]) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Модальное окно добавление комментария-->
    <div class="modal fade" id="addComment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="text-center">
                        <h4 class="modal-title" id="myModalLabel">добавить комментарий</h4>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="text-center">

                        <?php $form = ActiveForm::begin(['id' => 'addComment', 'action' => '/comment/add']); ?>

                        <?= Html::activeHiddenInput($formComment, 'news_id') ?>
                        <?= Html::activeHiddenInput($formComment, 'user_id') ?>
                        <?= $form->field($formComment, 'comment')->label('комментарий')->textarea(['rows' => '8']) ?>

                        <div class="form-group">
                            <?= Html::submitButton('добавить комментарий', ['class' => 'btn btn-default',]) ?>

                            <!--                            --><?php //echo $modelComment->id;?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно редактирования комментария-->
    <div class="modal fade" id="editComment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="text-center">
                        <h4 class="modal-title" id="myModalLabel">редактровать комментарий</h4>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="text-center">

                        <?php $form = ActiveForm::begin(['id' => 'editComment', 'action' => '/comment/edit']); ?>

                        <?= Html::activeHiddenInput($formComment, 'id') ?>
                        <?= $form->field($formComment, 'comment')->label('комментарий')->textarea(['rows' => '8']) ?>

                        <div class="form-group">
                            <?= Html::submitButton('редактировать комментарий', ['class' => 'btn btn-sm btn-default',]) ?>
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