<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Report;
use Carbon\Carbon;
use Faker\Generator as Faker;



$factory->define(Report::class, function (Faker $faker) {

    $statuses = ['initial','onprogress','ondonation','completed'];
    return [
        'title' => $faker->sentence(3),
        'category' => $faker->sentence(1),
        'location' => $faker->address,
        'target_donation' => $faker->randomNumber(7,true),
        'due_date' => Carbon::today()->subDays(rand(0,365))->format('D,d M Y'),
        'status' => $faker->randomElement($statuses)
        //
    ];
});
