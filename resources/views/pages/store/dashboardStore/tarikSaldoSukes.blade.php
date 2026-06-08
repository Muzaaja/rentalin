<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penarikan Berhasil - Rentalin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        body { background: #F5F7FA; font-family: 'Inter', sans-serif; }
        .page-wrap { width: 100%; max-width: 1289px; margin: 0 auto; padding: 60px 40px; box-sizing: border-box; }
        .success-card {
            background: #fff; border-radius: 14px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.07);
            padding: 60px 40px; text-align: center; max-width: 560px; margin: 0 auto;
        }
        .check-circle {
            width: 80px; height: 80px; border-radius: 50%;
            background: #34699A; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 36px; margin: 0 auto 24px;
        }
        .success-title { font-size: 22px; font-weight: 700; color: #1E1E1E; margin: 0 0 8px; }
        .success-sub   { font-size: 14px; color: #6B7280; margin: 0 0 32px; }

        .detail-box {
            background: #F9FAFB; border-radius: 10px;
            padding: 20px 24px; margin-bottom: 32px; text-align: left;
        }
        .detail-row { display: flex; justify-content: space-between; font-size: 13px; color: #374151; margin-bottom: 10px; }
        .detail-row:last-child { margin-bottom: 0; }
        .detail-row span:last-child { font-weight: 600; color: #1E1E1E; }
        .detail-row .amount { font-size: 18px; font-weight: 800; color: #34699A; font-family: 'Plus Jakarta Sans', sans-serif; }

        .badge-diproses {
            display: inline-block; background: #DBEAFE; color: #1E40AF;
            font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 20px;
        }

        .info-note {
            background: #DBEAFE; border-radius: 8px; padding: 12px 16px;
            font-size: 13px; color: #1E40AF; margin-bottom: 32px; text-align: left;
        }

        .btn-group { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .btn-primary {
            background: #34699A; color: #fff; font-family: inherit;
            font-size: 14px; font-weight: 600; padding: 13px 32px;
            border-radius: 8px; border: none; cursor: pointer;
            text-decoration: none; transition: background .2s; display: inline-block;
        }
        .btn-primary:hover { background: #2b5a87; }
        .btn-outline {
            background: #fff; color: #34699A; font-family: inherit;
            font-size: 14px; font-weight: 600; padding: 13px 32px;
            border-radius: 8px; border: 1.5px solid #34699A; cursor: pointer;
            text-decoration: none; transition: background .2s; display: inline-block;
        }
        .btn-outline:hover { background: #EFF6FF; }
    </style>
</head>
<body>

    @include('layouts.partials.navbar')

    <main class="page-wrap">
        <div class="success-card">

            <div class="check-circle">✓</div>

            <h2 class="success-title">Permintaan Penarikan Dikirim!</h2>
            <p class="success-sub">Penarikan saldo kamu sedang diproses oleh tim Rentalin</p>

            <div class="detail-box">
                <div class="detail-row">
                    <span>Jumlah</span>
                    <span class="amount">Rp {{ number_format($withdrawal->jumlah, 0, ',', '.') }}</span>
                </div>
                <div class="detail-row">
                    <span>Kode Referensi</span>
                    <span>{{ $withdrawal->ref_code }}</span>
                </div>
                <div class="detail-row">
                    <span>Tujuan Bank</span>
                    <span>{{ $withdrawal->nama_bank }}</span>
                </div>
                <div class="detail-row">
                    <span>Nomor Rekening</span>
                    <span>{{ $withdrawal->nomor_rekening }}</span>
                </div>
                <div class="detail-row">
                    <span>Atas Nama</span>
                    <span>{{ $withdrawal->nama_pemilik }}</span>
                </div>
                <div class="detail-row">
                    <span>Status</span>
                    <span><span class="badge-diproses">Diproses</span></span>
                </div>
                <div class="detail-row">
                    <span>Tanggal Pengajuan</span>
                    <span>{{ $withdrawal->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>

            <div class="info-note">
                ℹ️ Dana akan masuk ke rekening kamu dalam <strong>1–3 hari kerja</strong>. Simpan kode referensi <strong>{{ $withdrawal->ref_code }}</strong> untuk keperluan konfirmasi.
            </div>

            <div class="btn-group">
                <a href="{{ route('store.keuangan') }}" class="btn-primary">Lihat Riwayat Keuangan</a>
                <a href="{{ route('store.dashboardToko') }}" class="btn-outline">Kembali ke Dashboard</a>
            </div>

        </div>
    </main>

    @include('layouts.partials.footer')

</body>
</html>