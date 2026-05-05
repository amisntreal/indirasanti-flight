<?php

namespace Database\Seeders;

use App\Models\Airline;
use Illuminate\Database\Seeder;

class AirlineSeeder extends Seeder
{
    public function run(): void
    {
        $airlines = [
            ['name' => 'Garuda Indonesia', 'code' => 'GA', 'description' => 'Maskapai penerbangan nasional Indonesia yang melayani rute domestik dan internasional.'],
            ['name' => 'Lion Air', 'code' => 'JT', 'description' => 'Maskapai penerbangan berbiaya rendah terbesar di Indonesia.'],
            ['name' => 'Batik Air', 'code' => 'ID', 'description' => 'Maskapai full-service anak perusahaan Lion Air Group.'],
            ['name' => 'Citilink', 'code' => 'QG', 'description' => 'Maskapai penerbangan berbiaya rendah anak perusahaan Garuda Indonesia.'],
            ['name' => 'AirAsia Indonesia', 'code' => 'QZ', 'description' => 'Maskapai penerbangan berbiaya rendah internasional.'],
            ['name' => 'Qatar Airways', 'code' => 'QR', 'description' => 'Maskapai penerbangan nasional Qatar, salah satu yang terbaik di dunia.'],
            ['name' => 'Malaysia Airlines', 'code' => 'MH', 'description' => 'Maskapai penerbangan nasional Malaysia.'],
            ['name' => 'Singapore Airlines', 'code' => 'SQ', 'description' => 'Maskapai penerbangan nasional Singapura yang legendaris.'],
            ['name' => 'Emirates', 'code' => 'EK', 'description' => 'Maskapai penerbangan internasional terbesar di dunia yang berbasis di Dubai.'],
            ['name' => 'Japan Airlines', 'code' => 'JL', 'description' => 'Maskapai penerbangan nasional Jepang.'],
        ];

        foreach ($airlines as $airline) {
            Airline::create($airline);
        }
    }
}
