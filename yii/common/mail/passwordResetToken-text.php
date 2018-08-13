<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->username ?>,

Воспользуйтесь этой ссылкой для изменения своего пароля:

<?= $resetLink ?>

Если вы передумали менять пароль, то, просто, проигнорируйте это сообщение.
