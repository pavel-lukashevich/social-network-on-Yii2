<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="text-center">
        <h1>редактирование <?= Yii::$app->user->id; ?></h1>
    </div>
    <div class="jumbotron">

        <div class="body-content">

            <div class="row">



                <?php $form = ActiveForm::begin([
                    'id' => 'profile-edit',
                    'options' => [
                            'class' => 'form-group row',
                            'method' => 'post',
                            'enctype' => 'multipart/form-data',
                    ],
                ]) ?>

                    <?php foreach ($model as $key => $param): ?>
                       <div class="form-group row">

                        <?php echo $form->field($model, $key)->textInput(['value' => $key])->input('string', ['class' => 'col-sm-7 col-form-label'])->label($key, ['class' => 'col-sm-5 col-form-label']); ?>
<!--                        --><?//= $form->field($profile, $key)->hint('Пожалуйста, заполните это')->label($key); ?>

                       </div>
                    <?php endforeach; ?>


                    <div class="form-group">
                        <div class="col-lg-offset-1 col-lg-11">
                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                <?php ActiveForm::end() ?>

        </div>
    </div>
</div>
