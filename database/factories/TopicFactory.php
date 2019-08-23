<?php

use Faker\Generator as Faker;

if (isset($factory)) {
    $factory->define(App\Models\Topic::class, function (Faker $faker) {

        $sentence = $faker->sentence();

        // 隨機取一個月以內的時間
        $updated_at = $faker->dateTimeThisMonth();
        // 傳參為生成最大時間不超過，創建時間永遠比更改時間要早
        $created_at = $faker->dateTimeThisMonth($updated_at);

        return [
            'title' => $sentence,
            'body' => $faker->text(),
            'excerpt' => $sentence,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ];
    });
}
