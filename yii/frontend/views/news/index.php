<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $news \frontend\controllers\NewsController */
/* @var $users \common\models\User */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>




    <p>
        <?= Html::a('Create News', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <div class="body-content text-center">
        <?php foreach ($news as $newsItem): ?>
            <div class='row list-user'>
                <div class='col-md-4 col-xs-4'>
                    <a href='/profile/<?= $newsItem->user_id; ?>' class='btn'>
                       <p> <img src='<?= $users[$newsItem->user_id]->getPicture(); ?>' class='img-rounded' width='70px'/>
    <!--                </a>-->
    <!--                <a href='/profile/$newsItem->user_id' class='btn'>-->
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
                                <?= Html::encode($newsItem->heading); ?>
                            </p>
                        </div>
                        <div class='col-md-6'>
                            <p>
                                <?= $newsItem->date; ?>
                            </p>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-12'>
                            <p>
                                <?= Html::encode($newsItem->preview); ?>
                            </p>
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
