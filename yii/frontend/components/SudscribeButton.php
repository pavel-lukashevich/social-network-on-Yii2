<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 02.08.2018
 * Time: 20:11
 */

namespace frontend\components;


class SudscribeButton
{
    public static function run()
   {
        echo "
            <center>
                <a class='btn btn-default' href = '/friends/all/' > все </a >
                <a class='btn btn-default' href = '/friends/subscribe/' > подписки </a >
                <a class='btn btn-default' href = '/friends/follower/' > подписчики </a >
                <a class='btn btn-default' href = '/friends/mutuality/' > друзья </a >
            </center>";
   }

    public static function list($user, $btn)
    {
        echo "<div class='center-block'>";
        foreach ($user as $sub){
            $div = empty($div) ? 0 : $div;
            if ($div++ % 2 == 0) echo "<div class='row'>";

            echo "<div class='col-sm-6'>
                <div class='col-sm-4'>
                    <a href='/profile/" . $sub->id ."' class='btn'>
                        <img src='" . $sub->getPicture() ."' class='img-circle' width='70px'/>
                    </a>
                </div>
                <div class='col-sm-8'>
                    <a href='/profile/" . $sub->id . "' class='btn'>" . $sub->username . "</a>
                    <p>";

            if ($btn == "add" || $btn == "all") {
                echo "<a class='btn btn-sm  btn-default' href='/friends/add-subscribe/follow_id=" . $sub->id . "'>подписаться</a>";
            }
            if ($btn == "delete" || $btn == "all") {
                echo "<a class='btn btn-sm  btn-default' href = '/friends/delete-subscribe/follow_id=" . $sub->id . "' > отписаться</a >";
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
