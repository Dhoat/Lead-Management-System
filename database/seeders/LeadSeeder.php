<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lead;
use Faker\Factory as Faker;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 20; $i++) { 
            Lead::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'mobile' => $faker->phoneNumber,
                'description' => $faker->sentence,
                'source' => $faker->randomElement(['Facebook', 'Google', 'LinkedIn']),
                'status' => $faker->randomElement(['new', 'accepted', 'completed', 'rejected', 'invalid']),
            ]);
        }
    }
}
