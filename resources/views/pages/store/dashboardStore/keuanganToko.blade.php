<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keuangan - Rentalin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        body { background: #F5F7FA; font-family: 'Inter', sans-serif; }

        .page-wrap { width: 100%; max-width: 1289px; margin: 0 auto; padding: 28px 40px 60px; box-sizing: border-box; }

        /* ── Header ── */
        .page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
        .btn-back { display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .btn-back img { width: 36px; height: 36px; display: block; }
        .page-title { font-size: 20px; font-weight: 700; color: #1E1E1E; margin: 0; }

        /* ── Cards ── */
        .card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.07);
            padding: 28px 32px;
            margin-bottom: 24px;
        }

        /* ── Summary row ── */
        .summary-row {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 24px;
            margin-bottom: 24px;
        }
        .summary-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.07);
            padding: 28px 32px;
        }
        .summary-label { font-size: 12px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
        .summary-amount { font-size: 32px; font-weight: 800; color: #1E1E1E; font-family: 'Plus Jakarta Sans', sans-serif; }

        .saldo-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.07);
            padding: 28px 32px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .saldo-label { font-size: 12px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
        .saldo-amount { font-size: 28px; font-weight: 800; color: #1E1E1E; font-family: 'Plus Jakarta Sans', sans-serif; margin-bottom: 16px; }
        .btn-tarik {
            background: #34699A;
            color: #fff;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 600;
            padding: 11px 24px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            align-self: flex-end;
            transition: background 0.2s;
            text-decoration: none;
            text-align: center;
        }
        .btn-tarik:hover { background: #2b5a87; color: #fff; }

        /* ── Transaksi table ── */
        .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }
        .table-title { font-size: 16px; font-weight: 700; color: #1E1E1E; margin: 0; }
        .filter-btn {
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            background: #F3F4F6;
            border: none;
            padding: 7px 14px;
            border-radius: 8px;
            cursor: pointer;
        }

        .trx-table { width: 100%; border-collapse: collapse; }
        .trx-table th {
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: #9CA3AF;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 16px;
            background: #F9FAFB;
        }
        .trx-table th:first-child { border-radius: 8px 0 0 8px; }
        .trx-table th:last-child { border-radius: 0 8px 8px 0; text-align: right; }
        .trx-table td {
            padding: 16px;
            font-size: 14px;
            color: #374151;
            border-bottom: 1px solid #F3F4F6;
            vertical-align: middle;
        }
        .trx-table tr:last-child td { border-bottom: none; }
        .trx-table td:last-child { text-align: right; font-weight: 700; font-size: 16px; }

        .trx-date { font-weight: 500; color: #1E1E1E; }
        .trx-desc-main { font-weight: 500; color: #1E1E1E; font-size: 14px; }
        .trx-desc-sub { font-size: 12px; color: #9CA3AF; margin-top: 2px; }

        .badge-status {
            display: inline-block;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
        }
        .badge-selesai { background: #D1FAE5; color: #065F46; }
        .badge-diproses { background: #DBEAFE; color: #1E40AF; }
        .badge-gagal { background: #FEE2E2; color: #991B1B; }

        .amount-plus { color: #059669; }
        .amount-minus { color: #DC2626; }
    </style>
</head>
<body>

    @include('layouts.partials.navbar')

    <main class="page-wrap">

        {{-- Header --}}
        <div class="page-header">
            <a href="{{ route('store.dashboardToko') }}" class="btn-back">
                <img src="{{ asset('assets/icons/arrow-left-circle.png') }}" alt="Kembali">
            </a>
            <h1 class="page-title">Keuangan</h1>
        </div>

        {{-- Summary Row --}}
        <div class="summary-row">

            {{-- Ringkasan Pendapatan Dinamis dari Controller --}}
            <div class="summary-card">
                <div class="summary-label">Ringkasan Pendapatan</div>
                <div class="summary-amount">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</div>
            </div>

            {{-- Total Saldo Dinamis dari Controller --}}
            <div class="saldo-card">
                <div>
                    <div class="saldo-label">Total Saldo</div>
                    <div class="saldo-amount">Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}</div>
                </div>
                {{-- REVISI: Link Button ini dihubungkan langsung ke route Tarik Saldo --}}
                <a href="{{ route('store.tarikSaldo') }}" class="btn-tarik">Tarik Saldo</a>
            </div>

        </div>

        {{-- Riwayat Transaksi Penarikan Dinamis --}}
        <div class="card">
            <div class="table-header">
                <h2 class="table-title">Riwayat Penarikan</h2>
                <button class="filter-btn">Terbaru ▾</button>
            </div>

            <table class="trx-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($withdrawals ?? [] as $wd)
                        <tr>
                            <td><span class="trx-date">{{ $wd->created_at->translatedFormat('d M Y, H:i') }}</span></td>
                            <td>
                                <div class="trx-desc-main">Penarikan Dana ke {{ $wd->nama_bank }}</div>
                                <div class="trx-desc-sub">REF: {{ $wd->ref_code ?? '-' }} | a/n {{ $wd->nama_pemilik }}</div>
                            </td>
                            <td>
                                @if($wd->status == 'selesai' || $wd->status == 'sukses')
                                    <span class="badge-status badge-selesai">Selesai</span>
                                @elseif($wd->status == 'gagal')
                                    <span class="badge-status badge-gagal">Gagal</span>
                                @else
                                    <span class="badge-status badge-diproses">Diproses</span>
                                @endif
                            </td>
                            <td class="amount-minus">- Rp {{ number_format($wd->jumlah ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 30px; color: #9CA3AF;">
                                Belum ada riwayat penarikan dana untuk toko ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Menampilkan Pagination jika datanya lebih dari 1 halaman --}}
            @if(isset($withdrawals) && method_exists($withdrawals, 'links'))
                <div style="margin-top: 20px;">
                    {{ $withdrawals->links() }}
                </div>
            @endif
        </div>

    </main>

    @include('layouts.partials.footer')

</body>
</html>