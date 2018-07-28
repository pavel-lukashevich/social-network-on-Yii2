<?php

namespace frontend\controllers;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use yii\web\Controller;

/**
 * Site controller
 */
class FakerController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     *  добавляет в БД $y записей (по умолчанию 10)
     * @return integer
     */
    public function actionSignup()
    {
        $y = 10000;
        //снимаем ограничение с времени выполнения скрипта
        set_time_limit(0);

        $strfaker = 0;

        for ($i = 0; $i < $y; $i++) {
            $faker = \Faker\Factory::create('ru_RU');

            $user = new User();
            $user->username = $faker->firstName . " " . $faker->lastName;
            $user->email = $faker->email;
            $user->setPassword("123456789");
            $user->generateAuthKey();

            if (User::find()->where(["username" => $user->username, "email" => $user->email]) != 0) {
                $user->username .= " " . mt_rand();
            }
            if (User::find()->where(["username" => $user->email, "email" => $user->email]) != 0) {
                $user->email = mt_rand() . $user->email;
            }
            if ($user->save()) $strfaker++;
        }

        $countId = User::find()->count();

        return $this->render('signup', [
            'strfaker' => $strfaker,
            'countId' => $countId,
        ]);
    }
}
