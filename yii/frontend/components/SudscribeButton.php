<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 02.08.2018
 * Time: 20:11
 */

namespace frontend\components;

use frontend\models\Friends;

class SudscribeButton
{
    public static function run($myId, $userId = null)
   {

       $buttonUrl = [
           'all' => 'все пользователи',
           'subscribe' => 'подписки',
           'follower' => 'подписчики',
           'mutuality' => 'друзья'
       ];

       $url = \Yii::$app->request->pathInfo;

       if ($myId == $userId || $userId == null) {

           echo "<center>";
           foreach ($buttonUrl as $key => $val){
                echo "<a href = '/friends/" . $key . "'  class='btn btn-default ";
                echo (stristr ($url, $key)) ?  "active" : "";
                echo "'> " . $val . " </a>";
           }
            echo "</center>";
       } else {
           foreach ($buttonUrl as $key => $val){
//               echo "вы смотрите раздел ";
               echo (stristr ($url, $key)) ?  "<center>вы смотрите раздел <b>$val</b> пользователя $userId." : "";
//               echo "'> " . $val . " </a>";
           }
           echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='btn btn-default' href = '/profile/" . $userId . "' > назад к профилю </a></center>";
       }
   }

}
