<?php

use App\ReportImage;
use Illuminate\Database\Seeder;

class ReportImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ReportImage::class,20)->create();
        //
    }
}
