<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CommunitySeeder::class,
            ReportSeeder::class,
            ReportImageSeeder::class,
            DonationSeeder::class
        ]);
    }
}
