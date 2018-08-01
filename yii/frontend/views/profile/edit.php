<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'Редактирование профиля';
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

<!--                ///////////////////////////////////////////////////////////////-->
<!--                // расписать все инпуты отдельно-->
                <?php foreach ($model as $key => $param): ?>
                    <div class="form-group row">
                        <?php if ($key != 'avatar'): ?>

                            <?= $form->field($model, $key)->textInput(['autofocus' => true]) ?>

<!--                            --><?php //echo $form->field($model, $key)->label($key, ['class' => 'col-sm-5 col-form-label'])->
//                            textInput(['value' => $param, 'class' => 'col-sm-7']); ?>

                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
<!--                ///////////////////////////////////////////////////////////////-->

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end() ?>

            </div>
        </div>
    </div>
