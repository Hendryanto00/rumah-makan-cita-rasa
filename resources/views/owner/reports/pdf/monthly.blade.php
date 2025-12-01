<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Bulanan Penjualan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111827; }
        .header { border-bottom: 3px solid #f97316; padding-bottom: 15px; margin-bottom: 20px; }
        .header-top { text-align: center; }
        .restaurant-name { font-size: 24px; font-weight: bold; color: #f97316; margin-bottom: 5px; }
        .restaurant-subtitle { font-size: 11px; color: #666; margin-bottom: 5px; }
        .restaurant-address { font-size: 9px; color: #666; }
        h1 { font-size: 18px; margin: 15px 0 8px; text-align: center; color: #f97316; }
        .muted { color: #6b7280; text-align: center; margin-bottom: 16px; }
        .section { margin-top: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #e5e7eb; padding: 6px 8px; text-align: left; }
        th { background: #f3f4f6; }
        .right { text-align: right; }
    </style>
    </head>
<body>
    <div class="header">
        <div class="header-top">
            <div class="restaurant-name">Rumah Makan Cita Rasa</div>
            <div class="restaurant-subtitle">Sistem Pemesanan Makanan Online</div>
            <div class="restaurant-address">
                Jl. Kom Yos Sudarso No.04, Putussibau Kota, Kec. Putussibau Utara<br>
                Kab. Kapuas Hulu, Kalimantan Barat 78711
            </div>
        </div>
    </div>
    <h1>Laporan Bulanan Penjualan</h1>
    <div class="muted">Periode: {{ $monthStart->format('d M Y') }} - {{ $monthEnd->format('d M Y') }}</div>

    <div class="section">
        <table>
            <tr>
                <th>Total Pesanan</th>
                <th>Total Omzet</th>
                <th>Total Pelanggan</th>
                <th>Rata-rata Nilai Pesanan</th>
                <th>Pertumbuhan Omzet vs Bulan Lalu</th>
            </tr>
            <tr>
                <td class="right">{{ number_format($totalOrders, 0, ',', '.') }}</td>
                <td class="right">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                <td class="right">{{ number_format($totalCustomers, 0, ',', '.') }}</td>
                <td class="right">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</td>
                <td class="right">{{ number_format($revenueGrowth, 2, ',', '.') }}%</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3>Ringkasan Harian</h3>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th class="right">Omzet</th>
                    <th class="right">Pesanan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dailySummary as $d)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($d['date'])->format('d M Y') }}</td>
                        <td class="right">Rp {{ number_format($d['revenue'], 0, ',', '.') }}</td>
                        <td class="right">{{ number_format($d['orders'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Menu Laris Bulanan (Top 10)</h3>
        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Kategori</th>
                    <th class="right">Terjual</th>
                    <th class="right">Omzet</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topMenus as $m)
                    <tr>
                        <td>{{ $m->name }}</td>
                        <td>{{ $m->category_name }}</td>
                        <td class="right">{{ number_format($m->total_sold, 0, ',', '.') }}</td>
                        <td class="right">Rp {{ number_format($m->total_revenue, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>


