<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\EditProfileForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Редактирование профиля ';
?>

<div class="text-center">
        <h3><?= $this->title  . Yii::$app->user->identity->username; ?></h3>
</div>
<div class="text-center">
    <div class="list-user">

        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#changeUsername">изменить <?= Yii::$app->user->identity->username;?></button>

        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#changeEmail">изменить <?= Yii::$app->user->identity->email;?></button>

        <?= Html::a('изменить пароль', ['site/request-password-reset'], ['class' => 'btn btn-default']) ?>
        <br>
        <br>
    </div>
</div>

<!-- Модальное окно -->
<div class="modal fade" id="changeUsername" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="text-center">
                    <h4 class="modal-title" id="myModalLabel">изменить псевдоним</h4>
                </div>
            </div>
            <div class="modal-body">
                <div class="text-center">

                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'username')->textInput(['label' => 'имя пользователя']) ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton('изменить псевдоним', ['class' => 'btn btn-default', 'name' => 'edit_username']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно -->
<div class="modal fade" id="changeEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="text-center">
                    <h4 class="modal-title" id="myModalLabel"изменить email</h4>
                </div>
            </div>
            <div class="modal-body">
                <div class="text-center">

                    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                    <?= $form->field($model, 'email')->label('введите email')->textInput() ?>

                    <?= $form->field($model, 'password')->label('введите пароль')->passwordInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton('изменить email', ['class' => 'btn btn-default', 'name' => 'edit_email']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="text-center">
    <div class="list-user">
    <?php $form = ActiveForm::begin([
        'id' => 'form-profile_info_edit',
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
    <?= $form->field($model, 'about')->label('о себе')->textarea(['rows' => '8']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['name'=>'edit_info', 'class' => '"btn btn-secondary btn-sm"']) ?>
    </div>

    <?php ActiveForm::end() ?>

    </div>
</div>






















<!--////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<!---->
<!--<div class="site-index">-->
<!---->
<!--    <div class="text-center">-->
<!---->
<!--        <h3>--><?//= $this->title  . Html::encode($model->username); ?><!--</h3>-->
<!--    </div>-->
<!--    <div class="text-center">-->
<!---->
<!--        <div class="body-content">-->
<!---->
<!--            <div class="row">-->
<!--<!--форма для username, email, password-->-->
<!--                <div class="col-md-12">-->
<!--                    <div class="list-user">-->
<!--                        --><?php //$form = ActiveForm::begin([
//                            'id' => 'form-profile_username_edit',
//                            'enableClientValidation' => true,
//                            'options' => [
//                                'class' => 'form-group',
//                                'method' => 'post',
//                            ],
//                        ]) ?>
<!--                        <div class="col-md-6">-->
<!--                        --><?//= $form->field($model, 'username')->label('изменить псевдоним пользователя') ?>
<!--                        </div>-->
<!--                        <div class="col-md-6">-->
<!--                            --><?//= $form->field($model, 'password')->label('введите действующий пароль')->passwordInput() ?>
<!--                        </div>-->
<!--                        <div class="form-group">-->
<!--                            --><?//= Html::submitButton('Сохранить', ['name'=>'edit_username', 'class' => '"btn btn-secondary btn-sm"']) ?>
<!--                        </div>-->
<!---->
<!--                        --><?php //ActiveForm::end() ?>
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            -->






<!---->
<!--<!--форма для firstname, lastname, country, city-->-->
<!--            <div class="row">-->
<!--                <div class="col-md-1"></div>-->
<!--                <div class="col-md-10">-->
<!--                    <div class="list-user">-->
<!--                        --><?php //$form = ActiveForm::begin([
//                            'id' => 'form-profile_info_edit',
//                            'options' => [
//                                'class' => 'form-group',
//                                'method' => 'post',
//                            ],
//                        ]) ?>
<!---->
<!--                        --><?//= $form->field($model, 'firstname')->label('имя') ?>
<!--                        --><?//= $form->field($model, 'lastname')->label('фамилия') ?>
<!--                        --><?//= $form->field($model, 'country')->label('страна') ?>
<!--                        --><?//= $form->field($model, 'city')->label('город') ?>
<!--                        --><?//= $form->field($model, 'birthsday')->label('день рождения') ?>
<!--                        --><?//= $form->field($model, 'phone')->label('телефон') ?>
<!--                        --><?//= $form->field($model, 'education')->label('образование') ?>
<!--                        --><?//= $form->field($model, 'job')->label('работа') ?>
<!--                        --><?//= $form->field($model, 'about')->label('о себе') ?>
<!---->
<!--                        <div class="form-group">-->
<!--                            --><?//= Html::submitButton('Сохранить', ['name'=>'edit_profile_info', 'class' => '"btn btn-secondary btn-sm"']) ?>
<!--                        </div>-->
<!---->
<!--                        --><?php //ActiveForm::end() ?>
<!---->
<!--                        </div>-->
<!--                    </div>-->
<!--                <div class="col-md-1"></div>-->
<!--            </div>-->
<!---->
<!--            <!--форма смены email-->-->
<!--            <div class="row">-->
<!--                <div class="col-sm-6">-->
<!--                    <div class="list-user">-->
<!--                        --><?php //$form = ActiveForm::begin([
//                            'id' => 'form-profile_email_edit',
//                            'options' => [
//                                'class' => 'form-group',
//                                'method' => 'post',
//                            ],
//                        ]) ?>
<!---->
<!--                        --><?//= $form->field($model, 'email')->label('изменить email')->textInput() ?>
<!--                        --><?//= $form->field($model, 'password')->label('введите действующий пароль')->passwordInput() ?>
<!---->
<!--                        <div class="form-group">-->
<!--                            --><?//= Html::submitButton('Сохранить', ['name'=>'edit_email', 'class' => '"btn btn-secondary btn-sm"']) ?>
<!--                        </div>-->
<!---->
<!--                        --><?php //ActiveForm::end() ?>
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                <!--форма смены пароля-->-->
<!--                <div class="col-sm-6">-->
<!--                    <div class="list-user">-->
<!--                        --><?php //$form = ActiveForm::begin([
//                            'id' => 'form-profile_password_edit',
//                            'options' => [
//                                'class' => 'form-group',
//                                'method' => 'post',
//                            ],
//                        ]) ?>
<!---->
<!--                        --><?//= $form->field($model, 'newpassword')->label('новый пароль')->passwordInput() ?>
<!--                        --><?//= $form->field($model, 'password')->label('введите действующий пароль')->passwordInput() ?>
<!---->
<!--                        <div class="form-group">-->
<!--                            --><?//= Html::submitButton('Сохранить', ['name'=>'edit_password', 'class' => '"btn btn-secondary btn-sm"']) ?>
<!--                        </div>-->
<!---->
<!--                        --><?php //ActiveForm::end() ?>
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
</div>
