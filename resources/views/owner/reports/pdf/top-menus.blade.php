<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Menu Terlaris</title>
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
    <h1>Laporan Menu Terlaris</h1>
    <div class="muted">Periode: {{ $start->format('d M Y') }} - {{ $end->format('d M Y') }}</div>

    <div class="section">
        <h3>Berdasarkan Jumlah Terjual</h3>
        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Kategori</th>
                    <th class="right">Terjual</th>
                    <th class="right">Omzet</th>
                    <th class="right">Jumlah Pesanan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topMenusByQuantity as $m)
                    <tr>
                        <td>{{ $m->name }}</td>
                        <td>{{ $m->category_name }}</td>
                        <td class="right">{{ number_format($m->total_sold, 0, ',', '.') }}</td>
                        <td class="right">Rp {{ number_format($m->total_revenue, 0, ',', '.') }}</td>
                        <td class="right">{{ number_format($m->order_count, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Berdasarkan Kontribusi Omzet</h3>
        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Kategori</th>
                    <th class="right">Omzet</th>
                    <th class="right">Kontribusi</th>
                    <th class="right">Terjual</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topMenusByRevenue as $m)
                    <tr>
                        <td>{{ $m->name }}</td>
                        <td>{{ $m->category_name }}</td>
                        <td class="right">Rp {{ number_format($m->total_revenue, 0, ',', '.') }}</td>
                        <td class="right">{{ number_format($m->contribution_percentage, 2, ',', '.') }}%</td>
                        <td class="right">{{ number_format($m->total_sold, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>


