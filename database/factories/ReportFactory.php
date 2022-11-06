<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Community;
use App\Report;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;



$factory->define(Report::class, function (Faker $faker) {

    $statuses = ['initial','onprogress','ondonation','completed'];
    $user_ids = User::all()->pluck('id')->toArray();
    $ngo_ids = Community::all()->pluck('id')->toArray();
    return [
        'title' => $faker->sentence(3),
        'category' => $faker->sentence(1),
        'location' => $faker->address,
        'target_donation' => $faker->randomNumber(7,true),
        'due_date' => Carbon::today()->subDays(rand(0,365))->format('D,d M Y'),
        'status' => $faker->randomElement($statuses),
        'description' => $faker->paragraph(3),
        'user_id' => $faker->randomElement($user_ids),
        'community_id' => null,
        'pic_name' => $faker->name(),
        'docs' => $faker->imageUrl()
        //
    ];
});
