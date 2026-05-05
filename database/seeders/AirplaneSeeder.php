<?php

namespace Database\Seeders;

use App\Models\Airplane;
use App\Models\Airline;
use Illuminate\Database\Seeder;

class AirplaneSeeder extends Seeder
{
    public function run(): void
    {
        $airplanes = [
            // Garuda Indonesia (id=1)
            ['airline_id' => 1, 'model' => 'Boeing 777-300ER', 'registration_number' => 'PK-GIC', 'capacity' => 314, 'description' => 'Wide-body aircraft for long-haul routes.'],
            ['airline_id' => 1, 'model' => 'Boeing 737-800', 'registration_number' => 'PK-GFX', 'capacity' => 162, 'description' => 'Narrow-body aircraft for domestic routes.'],
            // Lion Air (id=2)
            ['airline_id' => 2, 'model' => 'Boeing 737-900ER', 'registration_number' => 'PK-LQP', 'capacity' => 215, 'description' => 'High-capacity narrow-body aircraft.'],
            ['airline_id' => 2, 'model' => 'Boeing 737 MAX 8', 'registration_number' => 'PK-LQF', 'capacity' => 189, 'description' => 'Modern fuel-efficient aircraft.'],
            // Batik Air (id=3)
            ['airline_id' => 3, 'model' => 'Airbus A320', 'registration_number' => 'PK-LBJ', 'capacity' => 180, 'description' => 'Modern Airbus family aircraft.'],
            ['airline_id' => 3, 'model' => 'Boeing 737-900ER', 'registration_number' => 'PK-LBM', 'capacity' => 215, 'description' => 'Full-service narrow-body aircraft.'],
            // Citilink (id=4)
            ['airline_id' => 4, 'model' => 'Airbus A320neo', 'registration_number' => 'PK-GLQ', 'capacity' => 180, 'description' => 'Next-generation fuel-efficient aircraft.'],
            // AirAsia (id=5)
            ['airline_id' => 5, 'model' => 'Airbus A320', 'registration_number' => 'PK-AZA', 'capacity' => 180, 'description' => 'Low-cost carrier aircraft.'],
            // Qatar Airways (id=6)
            ['airline_id' => 6, 'model' => 'Airbus A350-1000', 'registration_number' => 'A7-ANA', 'capacity' => 327, 'description' => 'Ultra-modern long-haul aircraft.'],
            ['airline_id' => 6, 'model' => 'Boeing 777-300ER', 'registration_number' => 'A7-BEE', 'capacity' => 354, 'description' => 'Spacious long-range aircraft.'],
            // Malaysia Airlines (id=7)
            ['airline_id' => 7, 'model' => 'Airbus A350-900', 'registration_number' => '9M-MAC', 'capacity' => 286, 'description' => 'Flagship Malaysian aircraft.'],
            // Singapore Airlines (id=8)
            ['airline_id' => 8, 'model' => 'Airbus A380-800', 'registration_number' => '9V-SKV', 'capacity' => 471, 'description' => 'World largest passenger aircraft.'],
            ['airline_id' => 8, 'model' => 'Boeing 787-10', 'registration_number' => '9V-SCA', 'capacity' => 337, 'description' => 'Modern Dreamliner.'],
            // Emirates (id=9)
            ['airline_id' => 9, 'model' => 'Airbus A380-800', 'registration_number' => 'A6-EEO', 'capacity' => 489, 'description' => 'Luxury double-decker aircraft.'],
            ['airline_id' => 9, 'model' => 'Boeing 777-300ER', 'registration_number' => 'A6-EGO', 'capacity' => 360, 'description' => 'Workhorse of Emirates fleet.'],
            // Japan Airlines (id=10)
            ['airline_id' => 10, 'model' => 'Boeing 777-300ER', 'registration_number' => 'JA731J', 'capacity' => 244, 'description' => 'Premium Japanese service aircraft.'],
        ];

        foreach ($airplanes as $airplane) {
            Airplane::create($airplane);
        }
    }
}
