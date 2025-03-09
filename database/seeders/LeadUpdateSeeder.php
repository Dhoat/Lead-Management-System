<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LeadUpdate;
use App\Models\Lead;
use Faker\Factory as Faker;

class LeadUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $leads = Lead::all(); 

        foreach ($leads as $lead) {
            for ($i = 1; $i <= 3; $i++) { 
                LeadUpdate::create([
                    'lead_id' => $lead->id,
                    'lead_message' => $faker->sentence,
                    'user' => $faker->name, 
                ]);
            }
        }
    }
}
