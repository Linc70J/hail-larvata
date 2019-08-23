<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = factory(User::class)
            ->times(10)
            ->make()
            ->each(function ($user) {
                $user->avatar = 'http://lorempixel.com/200/200/cats/';
            });

        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        User::insert($user_array);

        $user = User::find(1);
        $user->name = 'Linc';
        $user->email = 'qulamj@gmail.com';
        $user->avatar = 'http://lorempixel.com/200/200/cats/';
        $user->save();

        $user->assignRole('Founder');

        $user = User::find(2);
        $user->assignRole('Maintainer');

    }
}
