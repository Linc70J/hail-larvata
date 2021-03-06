<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

if (isset($factory)) {
    $factory->define(App\Models\User::class, function (Faker $faker) {
        static $password;
        $now = Carbon::now()->toDateTimeString();

        return [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => $password ?: $password = bcrypt('password'),
            'remember_token' => Str::random(10),
            'introduction' => $faker->sentence(),
            'created_at' => $now,
            'updated_at' => $now,
        ];
    });
}
