<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'payment'])->whereIn('status', ['confirmed']);

        // Default to current month if no dates provided
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfMonth();

        $query->whereBetween('created_at', [$startDate, $endDate]);

        if ($request->payment_method) {
            $query->whereHas('payment', function($q) use ($request) {
                $q->where('payment_method', $request->payment_method);
            });
        }

        $bookings = $query->orderBy('created_at', 'asc')->get();

        $totalRevenue = $bookings->sum('total_price');
        $totalBookings = $bookings->count();

        return view('admin.reports.index', compact('bookings', 'startDate', 'endDate', 'totalRevenue', 'totalBookings'));
    }

    public function exportCsv(Request $request)
    {
        $query = Booking::with(['user', 'payment'])->whereIn('status', ['confirmed']);

        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfMonth();

        $query->whereBetween('created_at', [$startDate, $endDate]);

        if ($request->payment_method) {
            $query->whereHas('payment', function($q) use ($request) {
                $q->where('payment_method', $request->payment_method);
            });
        }

        $bookings = $query->orderBy('created_at', 'asc')->get();

        $filename = "laporan_pendapatan_" . date('Ymd') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Tanggal', 'Kode Booking', 'Pelanggan', 'Metode Bayar', 'Total Penumpang', 'Total Harga (Rp)'];

        $callback = function() use($bookings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->created_at->format('Y-m-d H:i'),
                    $booking->booking_code,
                    $booking->user->name,
                    $booking->payment ? strtoupper($booking->payment->payment_method) : '-',
                    $booking->total_passengers,
                    $booking->total_price
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function printPdf(Request $request)
    {
        $query = Booking::with(['user', 'payment'])->whereIn('status', ['confirmed']);

        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfMonth();

        $query->whereBetween('created_at', [$startDate, $endDate]);

        if ($request->payment_method) {
            $query->whereHas('payment', function($q) use ($request) {
                $q->where('payment_method', $request->payment_method);
            });
        }

        $bookings = $query->orderBy('created_at', 'asc')->get();
        $totalRevenue = $bookings->sum('total_price');

        return view('admin.reports.print', compact('bookings', 'startDate', 'endDate', 'totalRevenue'));
    }
}
