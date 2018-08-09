<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Сброс пароля';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните свой email. Туда будет отправлена ​​ссылка на сброс пароля.</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('отправить', ['class' => 'btn btn-default']) ?>

                    <?php  if (!Yii::$app->user->isGuest) :?>
                        <a class='btn btn-default' href = '<?= Yii::$app->request->referrer;?>' >назад</a></center>
                    <?php endif;?>
                </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
