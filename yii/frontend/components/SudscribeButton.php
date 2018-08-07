<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 02.08.2018
 * Time: 20:11
 */

namespace frontend\components;

use common\models\User;
use frontend\models\Friends;

class SudscribeButton
{
    public static function run($myId, $userId = null)
   {

       $buttonUrl = [
           'all' => 'все пользователи',
           'subscribe' => 'подписки',
           'follower' => 'подписчики',
           'mutuality' => 'взаимные подписки'
       ];

       $user = User::find()->select(['username', 'firstname', 'lastname'])->where(['id' => $userId])->one();
       $name = ($user->firstname || $user->lastname) ? "$user->firstname $user->lastname" : "$user->username";

       $url = \Yii::$app->request->pathInfo;

       if ($myId == $userId || $userId == null) {

           echo "<center>";
           foreach ($buttonUrl as $key => $val){
                echo "<a href = '/friends/" . $key . "'  class='btn btn-default ";
                echo (stristr ($url, $key)) ? "active" : '';
                echo "'> " . $val . " </a>";
           }
            echo "</center>";
       } else {
           $str = [];
           foreach ($buttonUrl as $key => $val){
               if(stristr ($url, $key)){
                $str[0] = $key;
                $str[1] = $val;
               };
           }
           echo "<center><big>$str[1]</big> &nbsp;-&nbsp;";
           echo "<a class='btn btn-default' href = '/profile/" . $userId . "' >$name</a>";

           echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
           echo "<a class='btn btn-default ";
           echo (stristr ($url, 'common')) ? "active" : '';
           echo "' href = '/friends/common/" . $str[0] . "/id=" . $userId . "' > общие </a>";

           if (stristr ($url, 'common')){
               echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
               echo "<a class='btn btn-default' href = '/friends/subscribe/id=" . $userId . "' >назад</a></center>";
           }
       }
   }

}
