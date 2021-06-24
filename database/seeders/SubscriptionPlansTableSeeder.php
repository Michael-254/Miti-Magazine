<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;
use App\Models\Amount;

class SubscriptionPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        SubscriptionPlan::insert([
            ['location' => 'Kenya', 'quantity' => '1'],
            ['location' => 'Kenya', 'quantity' => '5'],
            ['location' => 'Kenya', 'quantity' => '10'],
            ['location' => 'Tanzania', 'quantity' => '1'],
            ['location' => 'Tanzania', 'quantity' => '5'],
            ['location' => 'Tanzania', 'quantity' => '10'],
            ['location' => 'Rest of World', 'quantity' => '5']
        ]);

        Amount::insert([
            ['digital' => 2000, 'printed' => 2000, 'combined' => 7000, 'subscription_plan_id' => 1],
            ['digital' => 9000, 'printed' => 9000, 'combined' => 11500, 'subscription_plan_id' => 2],
            ['digital' => 17000, 'printed' => 17000, 'combined' => 21000, 'subscription_plan_id' => 3],
            ['digital' => 7000, 'printed' => 7000, 'combined' => 10000, 'subscription_plan_id' => 4],
            ['digital' => 89000, 'printed' => 89000, 'combined' => 110000, 'subscription_plan_id' => 5],
            ['digital' => 200000, 'printed' => 200000, 'combined' => 250000, 'subscription_plan_id' => 6],
            ['digital' => 8000, 'printed' => 7000, 'combined' => 9000, 'subscription_plan_id' => 7]
        ]);
    }
}
