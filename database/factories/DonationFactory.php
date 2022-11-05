<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Donation;
use App\Report;
use Faker\Generator as Faker;
use App\User;

$factory->define(Donation::class, function (Faker $faker) {
    $user_ids = User::all()->pluck('id')->toArray();
    $report_ids = Report::all()->pluck('id')->toArray();
    return [
        'user_id' => $faker->randomElement($user_ids),
        'report_id' => $faker->randomElement($report_ids),
        'amount' => $faker->randomNumber(6,true)
        //
    ];
});
