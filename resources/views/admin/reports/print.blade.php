<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - Indirasanti Flight</title>
    <style>
        body { font-family: sans-serif; color: #333; margin: 40px; }
        h1 { font-size: 24px; margin-bottom: 5px; color: #78350f; } /* amber-900 */
        .subtitle { font-size: 14px; color: #666; mb-20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 13px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #fef3c7; color: #92400e; }
        .summary { margin-top: 30px; border: 1px solid #ddd; padding: 15px; width: 300px; }
        .summary p { margin: 5px 0; font-weight: bold; }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #78350f; color: white; border: none; cursor: pointer;">Cetak/Simpan PDF</button>
    </div>

    <h1>Laporan Keuangan Indirasanti Flight</h1>
    <p class="subtitle">Periode: {{ $startDate->format('d M Y') }} s/d {{ $endDate->format('d M Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kode Booking</th>
                <th>Pelanggan</th>
                <th>Metode Bayar</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->created_at->format('d M Y, H:i') }}</td>
                <td>{{ $booking->booking_code }}</td>
                <td>{{ $booking->user->name }}</td>
                <td style="text-transform: uppercase;">{{ $booking->payment->payment_method ?? '-' }}</td>
                <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <p>Total Pemesanan : {{ $bookings->count() }}</p>
        <p>Total Pendapatan: Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
</body>
</html>
