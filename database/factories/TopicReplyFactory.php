<?php

use Faker\Generator as Faker;

if (isset($factory)) {
    $factory->define(App\Models\TopicReply::class, function (Faker $faker) {

        // 隨機取一個月以內的時間
        $time = $faker->dateTimeThisMonth();

        return [
            'content' => $faker->sentence(),
            'created_at' => $time,
            'updated_at' => $time,
        ];
    });
}
