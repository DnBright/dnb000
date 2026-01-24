<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_id }}</title>
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            font-size: 11px;
            color: #000;
            margin: 0;
            padding: 40px;
            line-height: 1.5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .uppercase { text-transform: uppercase; }
        .font-black { font-weight: 900; }
        .font-bold { font-weight: 700; }
        .tracking-widest { letter-spacing: 0.1em; }
        .tracking-tighter { letter-spacing: -0.05em; }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 60px;
            border-bottom: 1px solid #eee;
            padding-bottom: 30px;
        }
        .brand-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .logo-box {
            width: 45px;
            height: 45px;
            background: #000;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 900;
        }
        .brand-name {
            font-size: 20px;
            font-weight: 900;
            line-height: 1.1;
        }
        .brand-sub {
            font-size: 8px;
            font-weight: 900;
            color: #666;
            margin-top: 4px;
        }
        .meta-section {
            text-align: right;
            font-size: 9px;
            font-weight: 700;
        }
        .meta-item {
            margin-bottom: 2px;
        }
        .meta-label { color: #666; }
        .meta-value { color: #000; }

        .section-label {
            font-size: 9px;
            font-weight: 900;
            letter-spacing: 0.2em;
            color: #000;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            display: inline-block;
            padding-bottom: 2px;
        }
        
        .info-grid {
            display: grid;
            grid-template-cols: 1fr 1fr;
            gap: 40px;
            margin-bottom: 60px;
        }

        .client-name {
            font-size: 24px;
            font-weight: 900;
            margin-bottom: 5px;
        }
        .client-detail {
            font-size: 10px;
            font-weight: 700;
            color: #666;
        }

        .manifest-item {
            font-size: 10px;
            font-weight: 900;
            margin-bottom: 4px;
        }
        .manifest-label { color: #666; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        th {
            text-align: left;
            font-size: 9px;
            font-weight: 900;
            letter-spacing: 0.1em;
            color: #666;
            padding: 15px 10px;
            border-bottom: 1px solid #000;
            background: #fcfcfc;
        }
        td {
            padding: 20px 10px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }
        .row-no { width: 40px; color: #999; font-weight: 900; }
        .row-desc { font-weight: 900; font-size: 12px; }
        .row-sub { font-size: 8px; color: #666; margin-top: 4px; font-weight: 700; }
        .text-right { text-align: right; }

        .summary-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 40px;
        }
        .status-box {
            max-width: 300px;
        }
        .status-label {
            font-size: 9px;
            font-weight: 900;
            color: #000;
            margin-bottom: 5px;
        }
        .status-desc {
            font-size: 9px;
            font-weight: 700;
            color: #666;
        }

        .total-box {
            min-width: 250px;
        }
        .total-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            font-size: 9px;
            font-weight: 900;
            color: #666;
        }
        .grand-total {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #000;
            color: #000;
        }
        .total-value-large {
            font-size: 20px;
            font-weight: 900;
            color: #000;
        }

        .terbilang-box {
            margin-top: 40px;
            padding: 15px;
            background: #f9f9f9;
            font-size: 10px;
            font-weight: 900;
            font-style: italic;
        }

        .signature-area {
            margin-top: 80px;
            display: grid;
            grid-template-cols: 1fr 1fr;
            text-align: center;
        }
        .signature-box {
            padding: 20px;
        }

        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #000;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: 900;
            font-size: 10px;
            letter-spacing: 0.1em;
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="print-btn no-print uppercase">Export PDF / Print</button>

    <div class="container">
        <div class="header">
            <div class="brand-section">
                <div class="logo-box">X</div>
                <div>
                    <div class="brand-name uppercase tracking-tighter">DARK & BRIGHT<br>STUDIO</div>
                    <div class="brand-sub uppercase tracking-widest">Jaringan Pertahanan Kreatif — IDN</div>
                </div>
            </div>
            <div class="meta-section uppercase tracking-widest">
                <div class="meta-item"><span class="meta-label">Protocol ID:</span> <span class="meta-value">#{{ $order->order_id }}</span></div>
                <div class="meta-item"><span class="meta-label">Diterbitkan Pada:</span> <span class="meta-value">{{ optional($order->created_at)->format('d M Y') }}</span></div>
                <div class="meta-item"><span class="meta-label">Registri Status:</span> 
                    <span class="meta-value">
                        @if($order->status === 'completed') SELESAI @elseif($order->status === 'submitted') MENUNGGU KOMITMEN @else {{ strtoupper($order->status) }} @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="info-grid">
            <div>
                <div class="section-label uppercase">CLIENT ENTITY</div>
                <div class="client-name uppercase tracking-tighter">{{ $order->customer->name ?? 'Unknown' }}</div>
                <div class="client-detail uppercase tracking-widest">{{ $order->customer->email ?? '' }}</div>
                <div class="client-detail uppercase tracking-widest">{{ $order->customer->phone ?? '' }}</div>
            </div>
            <div>
                <div class="section-label uppercase">ORDER MANIFEST</div>
                <div class="manifest-item uppercase tracking-widest"><span class="manifest-label">Payload Target:</span> {{ strtoupper($order->package->name ?? 'Design Protocol') }}</div>
                <div class="manifest-item uppercase tracking-widest"><span class="manifest-label">Referensi Sistem:</span> #DB-{{ $order->order_id }}</div>
                <div class="manifest-item uppercase tracking-widest"><span class="manifest-label">Tenggat Komitmen:</span> {{ optional($order->due_date)->format('d . M . Y') ?? optional($order->created_at)->addDays(7)->format('d . M . Y') }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr class="uppercase">
                    <th class="row-no">#</th>
                    <th>Payload Description</th>
                    <th>Units</th>
                    <th>Unit Rate</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="row-no">01</td>
                    <td>
                        <div class="row-desc uppercase tracking-tighter">{{ strtoupper($order->package->name ?? 'Design Service') }}</div>
                        <div class="row-sub uppercase tracking-widest">Implementasi Protokol Dasar</div>
                    </td>
                    <td>01</td>
                    <td class="uppercase font-bold">IDR {{ number_format($order->package->price ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right uppercase font-black">IDR {{ number_format($order->package->price ?? 0, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="summary-section">
            <div class="status-box">
                <div class="status-label uppercase tracking-widest">Protocol Status</div>
                <div class="status-desc uppercase tracking-widest">Memulai siklus sinkronisasi memerlukan komitmen yang aman. Pastikan seluruh payload telah sesuai dengan arahan desain.</div>
                
                <div class="terbilang-box uppercase tracking-widest">
                    Terbilang: {{ $terbilang }}
                </div>
            </div>
            <div class="total-box">
                <div class="total-item uppercase">
                    <span>Subtotal</span>
                    <span>IDR {{ number_format($order->package->price ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="total-item uppercase">
                    <span>Down Payment (DP)</span>
                    <span>IDR {{ number_format($dp ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="total-item uppercase">
                    <span>Sisa Pembayaran</span>
                    <span>IDR {{ number_format($sisa ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="total-item grand-total uppercase">
                    <span>Grand Total</span>
                    <span class="total-value-large tracking-tighter">IDR {{ number_format($order->package->price ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="signature-area">
            <div class="signature-box">
                <div class="client-detail uppercase tracking-widest" style="margin-bottom: 60px;">Client Authorization</div>
                <div style="border-bottom: 1px solid #000; width: 150px; margin: 0 auto;"></div>
            </div>
            <div class="signature-box">
                <div class="client-detail uppercase tracking-widest" style="margin-bottom: 60px;">Studio Synchronization</div>
                <div class="font-black uppercase tracking-tighter">DARK & BRIGHT</div>
                <div class="brand-sub uppercase tracking-widest">Lead Strategist</div>
            </div>
        </div>
    </div>

</body>
</html>
