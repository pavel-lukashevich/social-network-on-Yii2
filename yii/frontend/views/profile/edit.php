<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'Редактирование профиля';
?>
<div class="site-index">

    <div class="text-center">
        <h3>редактирование <?= $model->username; ?></h3>
    </div>
    <div class="text-center">

        <div class="body-content">

            <div class="row">
<!--форма для username, email, password-->
                <div class="col-md-12">
                    <div class="list-user">
                        <?php $form = ActiveForm::begin([
                            'id' => 'profile-edit',
                            'options' => [
                                'class' => 'form-group',
                                'method' => 'post',
                            ],
                        ]) ?>
                        <div class="col-md-6">
                        <?= $form->field($model, 'username')->label('изменить псевдоним пользователя') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'password')->label('введите действующий пароль')->passwordInput() ?>
                        </div>
                        <div class="form-group">
                            <?= Html::submitButton('Сохранить', ['name'=>'button1', 'class' => '"btn btn-secondary btn-sm"']) ?>
                        </div>

                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>

<!--форма для firstname, lastname, country, city-->
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="list-user">
                        <?php $form = ActiveForm::begin([
                            'id' => 'profile-edit',
                            'options' => [
                                'class' => 'form-group',
                                'method' => 'post',
                            ],
                        ]) ?>

                        <?= $form->field($model, 'firstname')->label('имя') ?>
                        <?= $form->field($model, 'lastname')->label('фамилия') ?>
                        <?= $form->field($model, 'country')->label('страна') ?>
                        <?= $form->field($model, 'city')->label('город') ?>
                        <?= $form->field($model, 'birthsday')->label('день рождения') ?>
                        <?= $form->field($model, 'phone')->label('телефон') ?>
                        <?= $form->field($model, 'education')->label('образование') ?>
                        <?= $form->field($model, 'job')->label('работа') ?>
                        <?= $form->field($model, 'about')->label('о себе') ?>

                        <div class="form-group">
                            <?= Html::submitButton('Сохранить', ['name'=>'button2', 'class' => '"btn btn-secondary btn-sm"']) ?>
                        </div>

                        <?php ActiveForm::end() ?>

                        </div>
                    </div>
                <div class="col-md-1"></div>
            </div>

            <!--форма смены email-->
            <div class="row">
                <div class="col-sm-6">
                    <div class="list-user">
                        <?php $form = ActiveForm::begin([
                            'id' => 'profile-edit-important',
                            'options' => [
                                'class' => 'form-group',
                                'method' => 'post',
                            ],
                        ]) ?>

                        <?= $form->field($model, 'email')->label('изменить email')->textInput() ?>
                        <?= $form->field($model, 'password')->label('введите действующий пароль')->passwordInput() ?>

                        <div class="form-group">
                            <?= Html::submitButton('Сохранить', ['name'=>'button3', 'class' => '"btn btn-secondary btn-sm"']) ?>
                        </div>

                        <?php ActiveForm::end() ?>
                    </div>
                </div>

                <!--форма смены пароля-->
                <div class="col-sm-6">
                    <div class="list-user">
                        <?php $form = ActiveForm::begin([
                            'id' => 'profile-edit-important',
                            'options' => [
                                'class' => 'form-group',
                                'method' => 'post',
                            ],
                        ]) ?>

                        <?= $form->field($model, 'newpassword')->label('новый пароль')->passwordInput() ?>
                        <?= $form->field($model, 'password')->label('введите действующий пароль')->passwordInput() ?>

                        <div class="form-group">
                            <?= Html::submitButton('Сохранить', ['name'=>'button4', 'class' => '"btn btn-secondary btn-sm"']) ?>
                        </div>

                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
