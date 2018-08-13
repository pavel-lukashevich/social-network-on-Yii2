<?php

/* @var $this yii\web\View */
/* @var $list string */
/* @var $news \frontend\controllers\NewsController */
/* @var $users \common\models\User */

use yii\helpers\Html;
use frontend\models\News;
use yii\bootstrap\ActiveForm;

$this->title = 'Новости';
//$this->params['breadcrumbs'][] = $this->title;
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

    <!-- Модальное окно -->
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
                    <div class="text-center">

                        <?php $form = ActiveForm::begin(['id' => 'addNews', 'action' => '/news/create']); ?>

                        <?= $form->field($model, 'heading')->textInput()->label('заголовок') ?>
                        <?= $form->field($model, 'tags')->textInput()->label('тэги') ?>
                        <?= $form->field($model, 'text')->label('новость')->textarea(['rows' => '8']) ?>

                        <div class="form-group">
                            <?= Html::submitButton('добавить новость', ['class' => 'btn btn-default',]) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="body-content text-center">
        <?php foreach ($news as $newsItem): ?>
            <div class='row list-user'>
                <div class='col-md-4 col-xs-4'>
                    <a href='/profile/<?= $newsItem->user_id; ?>' class='btn'>
                       <p>
                           <img src='<?= $users[$newsItem->user_id]->getPicture(); ?>' class='img-rounded' width='70px'/>
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
                            <p>
                                <?= Html::encode($newsItem->preview); ?>
                            </p>
<!--          like-dislike                  -->
<!--          like-dislike                  -->
                            <?php if ($newsItem->user_id != Yii::$app->user->id): ?>
                                <?php if (News::isRateLike($newsItem->id)): ?>
                                    <a class='btn btn-sm  btn-default' href='/news/like/post_id=<?= $newsItem->id;?>'> + </a>
                                <?php endif; ?>
                                <?php if (News::isRateDislike($newsItem->id)): ?>
                                    <a class='btn btn-sm  btn-default' href='/news/dislike/post_id=<?= $newsItem->id;?>'> - </a>
                                <?php endif; ?>
                            <?php else :?>
                                <a class='btn btn-sm  btn-default' href='/news/edit/post_id=<?= $newsItem->id;?>'>редактировать</a>
<!--                                <a class='btn btn-sm  btn-default' href='/news/delete/post_id=--><?//= $newsItem->id;?><!--'>удалить</a>-->
                            <?php endif; ?>
<!--            like-dislike-end                -->
<!--            like-dislike-end                -->
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php if (!empty($pagin))echo $pagin->get();?>

<!--//////////////////////////////////////////////-->
<?php //echo"<pre>"; var_dump($users)?>
<?php //echo"<pre><hr>"; var_dump($news);?>
<!-- --><?php //die;?>
<!--//////////////////////////////////////////////-->
