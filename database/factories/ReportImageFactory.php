<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Report;
use App\ReportImage;
use Faker\Generator as Faker;

$factory->define(ReportImage::class, function (Faker $faker) {
    $report_ids = Report::all()->pluck('id')->toArray();
    return [
        'report_id' => $faker->randomElement($report_ids),
        'image' => $faker->imageUrl(640, 480)
        //
    ];
});
