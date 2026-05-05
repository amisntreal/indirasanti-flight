<?php

namespace Database\Seeders;

use App\Models\Flight;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FlightSeeder extends Seeder
{
    public function run(): void
    {
        $flights = [
            // CGK -> DPS
            ['airline_id' => 1, 'airplane_id' => 1, 'departure_airport_id' => 1, 'arrival_airport_id' => 2, 'flight_number' => 'GA-404', 'departure_time' => Carbon::now()->addDays(3)->setTime(6, 0), 'arrival_time' => Carbon::now()->addDays(3)->setTime(8, 30), 'price' => 850000, 'available_seats' => 120],
            ['airline_id' => 2, 'airplane_id' => 3, 'departure_airport_id' => 1, 'arrival_airport_id' => 2, 'flight_number' => 'JT-606', 'departure_time' => Carbon::now()->addDays(3)->setTime(10, 0), 'arrival_time' => Carbon::now()->addDays(3)->setTime(12, 30), 'price' => 650000, 'available_seats' => 180],
            ['airline_id' => 4, 'airplane_id' => 7, 'departure_airport_id' => 1, 'arrival_airport_id' => 2, 'flight_number' => 'QG-822', 'departure_time' => Carbon::now()->addDays(3)->setTime(14, 0), 'arrival_time' => Carbon::now()->addDays(3)->setTime(16, 30), 'price' => 550000, 'available_seats' => 160],
            // CGK -> SUB
            ['airline_id' => 1, 'airplane_id' => 2, 'departure_airport_id' => 1, 'arrival_airport_id' => 3, 'flight_number' => 'GA-302', 'departure_time' => Carbon::now()->addDays(2)->setTime(7, 0), 'arrival_time' => Carbon::now()->addDays(2)->setTime(8, 30), 'price' => 750000, 'available_seats' => 140],
            ['airline_id' => 3, 'airplane_id' => 5, 'departure_airport_id' => 1, 'arrival_airport_id' => 3, 'flight_number' => 'ID-7301', 'departure_time' => Carbon::now()->addDays(2)->setTime(13, 0), 'arrival_time' => Carbon::now()->addDays(2)->setTime(14, 30), 'price' => 680000, 'available_seats' => 160],
            // CGK -> UPG
            ['airline_id' => 2, 'airplane_id' => 4, 'departure_airport_id' => 1, 'arrival_airport_id' => 4, 'flight_number' => 'JT-750', 'departure_time' => Carbon::now()->addDays(4)->setTime(8, 0), 'arrival_time' => Carbon::now()->addDays(4)->setTime(11, 0), 'price' => 900000, 'available_seats' => 170],
            ['airline_id' => 4, 'airplane_id' => 7, 'departure_airport_id' => 1, 'arrival_airport_id' => 4, 'flight_number' => 'QG-935', 'departure_time' => Carbon::now()->addDays(4)->setTime(16, 0), 'arrival_time' => Carbon::now()->addDays(4)->setTime(19, 0), 'price' => 780000, 'available_seats' => 150],
            // DPS -> CGK
            ['airline_id' => 1, 'airplane_id' => 1, 'departure_airport_id' => 2, 'arrival_airport_id' => 1, 'flight_number' => 'GA-405', 'departure_time' => Carbon::now()->addDays(5)->setTime(9, 0), 'arrival_time' => Carbon::now()->addDays(5)->setTime(11, 30), 'price' => 880000, 'available_seats' => 100],
            ['airline_id' => 2, 'airplane_id' => 3, 'departure_airport_id' => 2, 'arrival_airport_id' => 1, 'flight_number' => 'JT-607', 'departure_time' => Carbon::now()->addDays(5)->setTime(15, 0), 'arrival_time' => Carbon::now()->addDays(5)->setTime(17, 30), 'price' => 700000, 'available_seats' => 190],
            // CGK -> KNO
            ['airline_id' => 1, 'airplane_id' => 2, 'departure_airport_id' => 1, 'arrival_airport_id' => 5, 'flight_number' => 'GA-180', 'departure_time' => Carbon::now()->addDays(6)->setTime(6, 30), 'arrival_time' => Carbon::now()->addDays(6)->setTime(9, 0), 'price' => 1100000, 'available_seats' => 130],
            ['airline_id' => 5, 'airplane_id' => 8, 'departure_airport_id' => 1, 'arrival_airport_id' => 5, 'flight_number' => 'QZ-125', 'departure_time' => Carbon::now()->addDays(6)->setTime(11, 0), 'arrival_time' => Carbon::now()->addDays(6)->setTime(13, 30), 'price' => 850000, 'available_seats' => 165],
            // CGK -> JOG
            ['airline_id' => 4, 'airplane_id' => 7, 'departure_airport_id' => 1, 'arrival_airport_id' => 6, 'flight_number' => 'QG-811', 'departure_time' => Carbon::now()->addDays(1)->setTime(7, 0), 'arrival_time' => Carbon::now()->addDays(1)->setTime(8, 0), 'price' => 450000, 'available_seats' => 170],
            ['airline_id' => 3, 'airplane_id' => 6, 'departure_airport_id' => 1, 'arrival_airport_id' => 6, 'flight_number' => 'ID-6211', 'departure_time' => Carbon::now()->addDays(1)->setTime(12, 0), 'arrival_time' => Carbon::now()->addDays(1)->setTime(13, 0), 'price' => 480000, 'available_seats' => 200],
            // SUB -> DPS
            ['airline_id' => 2, 'airplane_id' => 3, 'departure_airport_id' => 3, 'arrival_airport_id' => 2, 'flight_number' => 'JT-900', 'departure_time' => Carbon::now()->addDays(7)->setTime(8, 0), 'arrival_time' => Carbon::now()->addDays(7)->setTime(9, 0), 'price' => 400000, 'available_seats' => 200],
            // CGK -> SIN
            ['airline_id' => 1, 'airplane_id' => 1, 'departure_airport_id' => 1, 'arrival_airport_id' => 11, 'flight_number' => 'GA-830', 'departure_time' => Carbon::now()->addDays(8)->setTime(10, 0), 'arrival_time' => Carbon::now()->addDays(8)->setTime(13, 30), 'price' => 2500000, 'available_seats' => 280],
            ['airline_id' => 5, 'airplane_id' => 8, 'departure_airport_id' => 1, 'arrival_airport_id' => 11, 'flight_number' => 'QZ-301', 'departure_time' => Carbon::now()->addDays(8)->setTime(14, 0), 'arrival_time' => Carbon::now()->addDays(8)->setTime(17, 30), 'price' => 1800000, 'available_seats' => 170],
            // CGK -> DOH (Qatar)
            ['airline_id' => 6, 'airplane_id' => 9, 'departure_airport_id' => 1, 'arrival_airport_id' => 13, 'flight_number' => 'QR-955', 'departure_time' => Carbon::now()->addDays(10)->setTime(0, 45), 'arrival_time' => Carbon::now()->addDays(10)->setTime(5, 15), 'price' => 12500000, 'available_seats' => 300],
            // CGK -> KUL (Malaysia)
            ['airline_id' => 7, 'airplane_id' => 11, 'departure_airport_id' => 1, 'arrival_airport_id' => 12, 'flight_number' => 'MH-710', 'departure_time' => Carbon::now()->addDays(4)->setTime(11, 10), 'arrival_time' => Carbon::now()->addDays(4)->setTime(14, 20), 'price' => 1500000, 'available_seats' => 250],
            // CGK -> DXB (Emirates)
            ['airline_id' => 9, 'airplane_id' => 15, 'departure_airport_id' => 1, 'arrival_airport_id' => 15, 'flight_number' => 'EK-357', 'departure_time' => Carbon::now()->addDays(7)->setTime(17, 40), 'arrival_time' => Carbon::now()->addDays(7)->setTime(23, 05), 'price' => 14000000, 'available_seats' => 320],
            // SIN -> LHR (Singapore)
            ['airline_id' => 8, 'airplane_id' => 12, 'departure_airport_id' => 11, 'arrival_airport_id' => 16, 'flight_number' => 'SQ-308', 'departure_time' => Carbon::now()->addDays(12)->setTime(9, 0), 'arrival_time' => Carbon::now()->addDays(12)->setTime(15, 30), 'price' => 18500000, 'available_seats' => 450],
            // CGK -> NRT (Japan Airlines)
            ['airline_id' => 10, 'airplane_id' => 16, 'departure_airport_id' => 1, 'arrival_airport_id' => 14, 'flight_number' => 'JL-720', 'departure_time' => Carbon::now()->addDays(5)->setTime(6, 45), 'arrival_time' => Carbon::now()->addDays(5)->setTime(16, 0), 'price' => 11500000, 'available_seats' => 220],
        ];

        foreach ($flights as $flight) {
            Flight::create($flight);
        }
    }
}
