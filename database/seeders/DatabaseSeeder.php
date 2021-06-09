<?php

namespace Database\Seeders;

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
        $this->call(CountriesTableSeeder::class);
        //\App\Models\SubscriptionPlan::factory(12)->create();
        //\App\Models\Amount::factory(12)->create();
    }
}
