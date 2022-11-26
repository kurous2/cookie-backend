<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Community;
use App\Helpers\Image;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Community::class, function (Faker $faker) {
    return [
        'is_verified' => $faker->boolean(80),
        'stamp' => Image::imageUrl(),
        'user_id' => function (array $attributes) {
            return factory(User::class)->create([
                'role' => 'community'
            ]);
        },
        //
    ];
});
