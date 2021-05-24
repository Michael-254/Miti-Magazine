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
        // \App\Models\User::factory(10)->create();
          \App\Models\SubscriptionPlan::factory(12)->create();
           \App\Models\Amount::factory(12)->create();
    }
}
