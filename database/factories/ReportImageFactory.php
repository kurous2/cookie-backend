<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Report;
use App\ReportImage;
use Faker\Generator as Faker;
use App\Helpers\Image;

$factory->define(ReportImage::class, function (Faker $faker) {
    $report_ids = Report::all()->pluck('id')->toArray();
    return [
        'report_id' => $faker->randomElement($report_ids),
        'image' => Image::imageUrl()
        //
    ];
});
