<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Pesanan #{{ $order->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #333;
            background: #fff;
        }
        
        .invoice-wrapper {
            max-width: 210mm;
            margin: 0 auto;
            padding: 10mm;
            background: white;
        }
        
        /* Header Section */
        .header {
            border-bottom: 3px solid #f97316;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .header-top {
            text-align: center;
        }
        
        .restaurant-name {
            font-size: 28px;
            font-weight: bold;
            color: #f97316;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }
        
        .restaurant-subtitle {
            font-size: 12px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .restaurant-address {
            font-size: 10px;
            color: #666;
            line-height: 1.4;
        }
        
        /* Invoice Title */
        .invoice-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #f97316;
            margin: 15px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        /* Info Boxes */
        .info-boxes {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .info-box {
            display: table-cell;
            vertical-align: top;
            width: 50%;
            padding: 10px;
            border: 1px solid #ddd;
            background: #f9f9f9;
        }
        
        .info-box-title {
            font-size: 11px;
            font-weight: bold;
            color: #f97316;
            margin-bottom: 8px;
            text-transform: uppercase;
            border-bottom: 1px solid #f97316;
            padding-bottom: 3px;
        }
        
        .info-item {
            margin-bottom: 4px;
            font-size: 10px;
        }
        
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 90px;
        }
        
        .info-value {
            display: inline-block;
        }
        
        /* Table Styling */
        .items-section {
            margin: 15px 0;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        
        .items-table thead th {
            background-color: #f97316;
            color: white;
            padding: 8px 5px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
            border: 1px solid #f97316;
        }
        
        .items-table thead th.number,
        .items-table tbody td.number {
            width: 40px;
            text-align: center;
        }
        
        .items-table thead th.name,
        .items-table tbody td.name {
            width: 180px;
            text-align: left;
        }
        
        .items-table thead th.qty,
        .items-table tbody td.qty {
            width: 60px;
            text-align: center;
        }
        
        .items-table thead th.price,
        .items-table tbody td.price {
            width: 100px;
            text-align: right;
        }
        
        .items-table thead th.total,
        .items-table tbody td.total {
            width: 120px;
            text-align: right;
        }
        
        .items-table tbody td {
            padding: 8px 5px;
            border: 1px solid #ddd;
            font-size: 10px;
            vertical-align: top;
        }
        
        .items-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .item-notes {
            font-style: italic;
            color: #666;
            font-size: 9px;
            margin-top: 4px;
        }
        
        /* Summary Section */
        .summary-section {
            margin: 15px 0;
        }
        
        .summary-box {
            border: 1px solid #ddd;
            background: #fff8f0;
            padding: 12px;
            margin-top: 10px;
        }
        
        .summary-row {
            display: table;
            width: 100%;
            margin-bottom: 6px;
        }
        
        .summary-label {
            display: table-cell;
            font-weight: bold;
            width: 40%;
            font-size: 11px;
        }
        
        .summary-value {
            display: table-cell;
            text-align: right;
            font-size: 11px;
        }
        
        .summary-total {
            border-top: 2px solid #f97316;
            padding-top: 8px;
            margin-top: 8px;
        }
        
        .summary-total .summary-label,
        .summary-total .summary-value {
            font-size: 14px;
            font-weight: bold;
            color: #f97316;
        }
        
        /* Payment Info */
        .payment-info {
            margin-top: 10px;
            padding: 8px;
            background: #f0f0f0;
            border-left: 3px solid #f97316;
            font-size: 10px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .status-paid {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        /* Footer */
        .footer {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid #f97316;
            text-align: center;
            font-size: 9px;
            color: #666;
        }
        
        .footer p {
            margin: 3px 0;
            line-height: 1.4;
        }
        
        .footer strong {
            color: #333;
        }
        
        /* Notes Section */
        .notes-box {
            margin-top: 15px;
            padding: 10px;
            background: #fff8f0;
            border-left: 4px solid #f97316;
        }
        
        .notes-title {
            font-weight: bold;
            font-size: 11px;
            color: #f97316;
            margin-bottom: 8px;
        }
        
        .notes-content {
            font-size: 9px;
            line-height: 1.5;
        }
        
        .notes-content ul {
            margin-left: 20px;
        }
        
        .notes-content li {
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
    <div class="invoice-wrapper">
        <!-- Header -->
        <div class="header">
            <div class="header-top">
                <div class="restaurant-name">Rumah Makan Cita Rasa</div>
                <div class="restaurant-subtitle">Sistem Pemesanan Makanan Online</div>
                <div class="restaurant-address">
                    Jl. Kom Yos Sudarso No.04, Putussibau Kota<br>
                    Kec. Putussibau Utara, Kab. Kapuas Hulu<br>
                    Kalimantan Barat 78711
                </div>
            </div>
        </div>
        
        <!-- Invoice Title -->
        <div class="invoice-title">NOTA PESANAN</div>
        
        <!-- Info Boxes -->
        <div class="info-boxes">
            <div class="info-box">
                <div class="info-box-title">Detail Pesanan</div>
                <div class="info-item">
                    <span class="info-label">No. Pesanan:</span>
                    <span class="info-value">{{ $order->id }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal:</span>
                    <span class="info-value">{{ $order->created_at->format('d-m-Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Waktu:</span>
                    <span class="info-value">{{ $order->created_at->format('H:i') }} WIB</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="status-badge status-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                @if($order->payment && $order->payment->transaction_id)
                <div class="info-item">
                    <span class="info-label">Trans. ID:</span>
                    <span class="info-value">{{ $order->payment->transaction_id }}</span>
                </div>
                @endif
            </div>
            
            <div class="info-box">
                <div class="info-box-title">Detail Pelanggan</div>
                <div class="info-item">
                    <span class="info-label">Nama:</span>
                    <span class="info-value">{{ $order->user->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $order->user->email }}</span>
                </div>
                @if($order->user->phone)
                <div class="info-item">
                    <span class="info-label">Telepon:</span>
                    <span class="info-value">{{ $order->user->phone }}</span>
                </div>
                @endif
                @if($order->user->address)
                <div class="info-item">
                    <span class="info-label">Alamat:</span>
                    <span class="info-value">{{ $order->user->address }}</span>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Items Section -->
        <div class="items-section">
            <table class="items-table">
                <thead>
                    <tr>
                        <th class="number">No</th>
                        <th class="name">Nama Menu</th>
                        <th class="qty">Qty</th>
                        <th class="price">Harga</th>
                        <th class="total">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->details as $index => $detail)
                    <tr>
                        <td class="number">{{ $index + 1 }}</td>
                        <td class="name">
                            <strong>{{ $detail->menu->name }}</strong>
                            @if($detail->notes)
                            <div class="item-notes">
                                Catatan: {{ $detail->notes }}
                            </div>
                            @endif
                        </td>
                        <td class="qty">{{ $detail->quantity }}</td>
                        <td class="price">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                        <td class="total">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Summary Section -->
        <div class="summary-section">
            <div class="summary-box">
                <div class="summary-row">
                    <div class="summary-label">Total Pesanan</div>
                    <div class="summary-value">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                </div>
                <div class="summary-row">
                    <div class="summary-label">Metode Pembayaran</div>
                    <div class="summary-value">{{ $order->payment ? ucfirst($order->payment->payment_method) : 'N/A' }}</div>
                </div>
                <div class="summary-row">
                    <div class="summary-label">Status Pembayaran</div>
                    <div class="summary-value">
                        <span class="status-badge status-{{ $order->payment ? $order->payment->payment_status : 'pending' }}">
                            {{ $order->payment ? ucfirst($order->payment->payment_status) : 'Pending' }}
                        </span>
                    </div>
                </div>
                <div class="summary-row summary-total">
                    <div class="summary-label">TOTAL</div>
                    <div class="summary-value">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        
        <!-- Notes -->
        <div class="notes-box">
            <div class="notes-title">Catatan Penting:</div>
            <div class="notes-content">
                <ul>
                    <li>Nota ini adalah bukti transaksi yang sah dari Rumah Makan Cita Rasa</li>
                    <li>Harap simpan nota ini sebagai bukti pembayaran</li>
                    <li>Terima kasih atas kunjungan Anda</li>
                </ul>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p><strong>Rumah Makan Cita Rasa</strong></p>
            <p>Telepon: 0813-5227-0928 | Email: rumahmakancitarasa5@gmail.com</p>
            <p>Nota ini dibuat otomatis pada {{ now()->format('d F Y, H:i:s') }} WIB</p>
        </div>
    </div>
</body>
</html>
