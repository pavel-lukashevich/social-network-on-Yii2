<?php

use yii\helpers\Html;
use frontend\models\News;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\News */
/* @var $user \common\models\User */

$this->title = Html::encode($model->heading);
//$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
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
                    <!--          like-dislike                  -->
                    <?php if ($model->user_id != Yii::$app->user->id): ?>
                        <?php if (News::isRateLike($model->id)): ?>
                            <a class='btn btn-sm  btn-default' href='/news/like/post_id=<?= $model->id;?>'> + </a>
                        <?php endif; ?>
                        <?php if (News::isRateDislike($model->id)): ?>
                            <a class='btn btn-sm  btn-default' href='/news/dislike/post_id=<?= $model->id;?>'> - </a>
                        <?php endif; ?>
                    <?php else :?>
                        <a class='btn btn-sm  btn-default' href='/news/edit/post_id=<?= $model->id;?>'>редактировать</a>

<!--                        <a class='btn btn-sm  btn-default' href='/news/delete/post_id=-->
<!--                        --><?php //
//                            echo $newsItem->id;
//                        ?>
<!--                        '>удалить</a>-->

                    <?php endif; ?>
                    <!--            like-dislike-end                -->
                    <!--            like-dislike-end                -->
                </div>
            </div>
        </div>
            <a class='btn btn-default' href = '<?= Yii::$app->request->referrer?>' >назад</a>
    </div>

</div>
