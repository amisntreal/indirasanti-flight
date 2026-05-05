<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Payment;
use App\Models\User;
use App\Models\Flight;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $flights = Flight::all();

        $bookingsData = [
            [
                'user_id' => $customers[0]->id,
                'flight_id' => 1,
                'booking_code' => 'IF-' . strtoupper(Str::random(8)),
                'total_passengers' => 2,
                'total_price' => 1700000,
                'status' => 'confirmed',
                'passengers' => [
                    ['full_name' => 'Budi Santoso', 'gender' => 'male', 'birth_date' => '1990-05-15', 'seat_number' => '1A'],
                    ['full_name' => 'Ani Santoso', 'gender' => 'female', 'birth_date' => '1992-08-20', 'seat_number' => '1B'],
                ],
                'payment' => ['payment_method' => 'bca', 'amount' => 1700000, 'payment_status' => 'paid', 'transaction_code' => 'TXN-' . Str::random(16)],
            ],
            [
                'user_id' => $customers[1]->id,
                'flight_id' => 4,
                'booking_code' => 'IF-' . strtoupper(Str::random(8)),
                'total_passengers' => 1,
                'total_price' => 750000,
                'status' => 'confirmed',
                'passengers' => [
                    ['full_name' => 'Siti Rahayu', 'gender' => 'female', 'birth_date' => '1995-03-10', 'seat_number' => '5C'],
                ],
                'payment' => ['payment_method' => 'bni', 'amount' => 750000, 'payment_status' => 'paid', 'transaction_code' => 'TXN-' . Str::random(16)],
            ],
            [
                'user_id' => $customers[2]->id,
                'flight_id' => 6,
                'booking_code' => 'IF-' . strtoupper(Str::random(8)),
                'total_passengers' => 3,
                'total_price' => 2700000,
                'status' => 'pending',
                'passengers' => [
                    ['full_name' => 'Ahmad Fauzi', 'gender' => 'male', 'birth_date' => '1988-11-25', 'seat_number' => '12A'],
                    ['full_name' => 'Nurul Fauzi', 'gender' => 'female', 'birth_date' => '1990-07-14', 'seat_number' => '12B'],
                    ['full_name' => 'Rafi Fauzi', 'gender' => 'male', 'birth_date' => '2015-02-28', 'seat_number' => '12C'],
                ],
                'payment' => ['payment_method' => 'bri', 'amount' => 2700000, 'payment_status' => 'pending', 'transaction_code' => 'TXN-' . Str::random(16)],
            ],
            [
                'user_id' => $customers[3]->id,
                'flight_id' => 10,
                'booking_code' => 'IF-' . strtoupper(Str::random(8)),
                'total_passengers' => 1,
                'total_price' => 1100000,
                'status' => 'confirmed',
                'passengers' => [
                    ['full_name' => 'Dewi Lestari', 'gender' => 'female', 'birth_date' => '1993-06-30', 'seat_number' => '8D'],
                ],
                'payment' => ['payment_method' => 'mandiri', 'amount' => 1100000, 'payment_status' => 'paid', 'transaction_code' => 'TXN-' . Str::random(16)],
            ],
            [
                'user_id' => $customers[4]->id,
                'flight_id' => 14,
                'booking_code' => 'IF-' . strtoupper(Str::random(8)),
                'total_passengers' => 2,
                'total_price' => 5000000,
                'status' => 'confirmed',
                'passengers' => [
                    ['full_name' => 'Rizky Pratama', 'gender' => 'male', 'birth_date' => '1991-09-18', 'seat_number' => '2A', 'passport_number' => 'A1234567'],
                    ['full_name' => 'Maya Pratama', 'gender' => 'female', 'birth_date' => '1993-12-05', 'seat_number' => '2B', 'passport_number' => 'B9876543'],
                ],
                'payment' => ['payment_method' => 'bca', 'amount' => 5000000, 'payment_status' => 'paid', 'transaction_code' => 'TXN-' . Str::random(16)],
            ],
        ];

        foreach ($bookingsData as $bookingData) {
            $passengers = $bookingData['passengers'];
            $paymentData = $bookingData['payment'];
            unset($bookingData['passengers'], $bookingData['payment']);

            $booking = Booking::create($bookingData);

            foreach ($passengers as $passenger) {
                $passenger['booking_id'] = $booking->id;
                Passenger::create($passenger);
            }

            $paymentData['booking_id'] = $booking->id;
            Payment::create($paymentData);
        }
    }
}
