<?php

namespace Database\Seeders;

use App\Models\Airport;
use Illuminate\Database\Seeder;

class AirportSeeder extends Seeder
{
    public function run(): void
    {
        $airports = [
            ['name' => 'Bandar Udara Internasional Soekarno-Hatta', 'city' => 'Jakarta', 'country' => 'Indonesia', 'iata_code' => 'CGK'],
            ['name' => 'Bandar Udara Internasional Ngurah Rai', 'city' => 'Bali', 'country' => 'Indonesia', 'iata_code' => 'DPS'],
            ['name' => 'Bandar Udara Internasional Juanda', 'city' => 'Surabaya', 'country' => 'Indonesia', 'iata_code' => 'SUB'],
            ['name' => 'Bandar Udara Internasional Sultan Hasanuddin', 'city' => 'Makassar', 'country' => 'Indonesia', 'iata_code' => 'UPG'],
            ['name' => 'Bandar Udara Internasional Kuala Namu', 'city' => 'Medan', 'country' => 'Indonesia', 'iata_code' => 'KNO'],
            ['name' => 'Bandar Udara Internasional Adisutjipto', 'city' => 'Yogyakarta', 'country' => 'Indonesia', 'iata_code' => 'JOG'],
            ['name' => 'Bandar Udara Internasional Ahmad Yani', 'city' => 'Semarang', 'country' => 'Indonesia', 'iata_code' => 'SRG'],
            ['name' => 'Bandar Udara Internasional Minangkabau', 'city' => 'Padang', 'country' => 'Indonesia', 'iata_code' => 'PDG'],
            ['name' => 'Bandar Udara Internasional Sepinggan', 'city' => 'Balikpapan', 'country' => 'Indonesia', 'iata_code' => 'BPN'],
            ['name' => 'Bandar Udara Internasional Sam Ratulangi', 'city' => 'Manado', 'country' => 'Indonesia', 'iata_code' => 'MDC'],
            ['name' => 'Singapore Changi Airport', 'city' => 'Singapore', 'country' => 'Singapore', 'iata_code' => 'SIN'],
            ['name' => 'Kuala Lumpur International Airport', 'city' => 'Kuala Lumpur', 'country' => 'Malaysia', 'iata_code' => 'KUL'],
            ['name' => 'Hamad International Airport', 'city' => 'Doha', 'country' => 'Qatar', 'iata_code' => 'DOH'],
            ['name' => 'Narita International Airport', 'city' => 'Tokyo', 'country' => 'Japan', 'iata_code' => 'NRT'],
            ['name' => 'Dubai International Airport', 'city' => 'Dubai', 'country' => 'United Arab Emirates', 'iata_code' => 'DXB'],
            ['name' => 'Heathrow Airport', 'city' => 'London', 'country' => 'United Kingdom', 'iata_code' => 'LHR'],
            ['name' => 'Sydney Kingsford Smith Airport', 'city' => 'Sydney', 'country' => 'Australia', 'iata_code' => 'SYD'],
        ];

        foreach ($airports as $airport) {
            Airport::create($airport);
        }
    }
}
