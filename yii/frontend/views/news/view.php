<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

/* @var $model frontend\models\News */
/* @var $user \common\models\User */

$this->title = Html::encode($model->heading);

?>
<div class="news-view">

    <div class='row list-user text-center'>

    <h2><?= $this->title; ?></h2>

        <div class='col-md-4 col-xs-4'>
            <a href='/profile/<?= $model->user_id; ?>' class='btn'>
                <p>
                    <img src='<?= $user->getPicture(); ?>' class='img-rounded' width='70px'/>
                </p>
                <p>
                    <?= Html::encode($user->username); ?>
                </p>
            </a>
        </div>
        <div class='col-md-8 col-xs-8'>
            <div class='row'>
                <div class='col-md-6'>
                    <p>
                        <?= Html::encode($model->tags); ?>
                    </p>
                </div>
                <div class='col-md-6'>
                    <p>
                        <?= date('d-m-Y / H:i', $model->date); ?>
                    </p>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-12'>
                    <p>
                        <?= Html::encode($model->text); ?>
                    </p>

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

    <!-- Модальное окно -->
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

                        <?php $form = ActiveForm::begin(['id' => 'addNews', 'action' => '/news/edit']); ?>

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



            <a class='btn btn-default' href = '<?= Yii::$app->request->referrer ;?>' >назад</a>
            <a class='btn btn-default pull-right' href = '/comment/add/post_id=<?php echo $model->id;?>' >добавить комментарий</a>

</div>


<?php
$this->registerJsFile('/js/likes.js', [
    'depends' => \yii\web\JqueryAsset::className(),
]);
?>