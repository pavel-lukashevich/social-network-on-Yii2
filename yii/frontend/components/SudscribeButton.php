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

       if ($myId == $userId || $userId == null) {

          $thisUrl = '/' . \Yii::$app->request->pathInfo;
           echo "<center>";
           foreach ($buttonUrl as $key => $val){
                echo "<a class='btn btn-default' href = '/friends/" . $key . "' ";
                echo ($thisUrl == $key) ?  "active" : "";
                echo "> " . $val . " </a>";
           }
            echo "</center>";
       } else {
           echo "<center><a class='btn btn-default' href = '/profile/" . $userId . "' > назад к профилю " . $userId . "</a></center>";
       }
   }

    public static function list($user)
    {
        echo "<div class='center-block'>";
        foreach ($user as $sub){
            $div = empty($div) ? 0 : $div;
            if ($div++ % 2 == 0) echo "<div class='row'>";

            echo "<div class='col-sm-6'>
                <div class='col-sm-4'>
                    <a href='/profile/" . $sub->id ."' class='btn'>
                        <img src='" . $sub->getPicture() ."' class='img-rounded' width='70px'/>
                    </a>
                </div>
                <div class='col-sm-8'>
                    <a href='/profile/" . $sub->id . "' class='btn'>" . $sub->username . "</a>
                    <p>";


            if (Friends::isSubscribe($sub->id)) {
                echo "<a class='btn btn-sm  btn-default' href = '/friends/delete-subscribe/follow_id=" . $sub->id . "' > отписаться</a >";
            } else {
                echo "<a class='btn btn-sm  btn-default' href='/friends/add-subscribe/follow_id=" . $sub->id . "'>подписаться</a>";
             }

                  echo "</p>
                        <hr>
                        </div>
                    </div>";

                    if ($div % 2 == 0 || $div == count($user)) echo '</div >';
                }
            echo "</div>";
    }
}
