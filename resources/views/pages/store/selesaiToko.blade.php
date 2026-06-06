<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Berhasil Dibuat - Rentalin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        .toko-wrap { width:100%; max-width:1289px; margin:0 auto; padding:28px 40px 60px; box-sizing:border-box; }

        /* Header */
        .toko-header { display:flex; align-items:center; gap:14px; margin-bottom:28px; }
        .btn-back-circle {
            width:36px; height:36px; border-radius:50%;
            border:1.5px solid #D1D5DB; background:#fff;
            display:flex; align-items:center; justify-content:center;
            text-decoration:none; color:#374151; transition:background .15s; flex-shrink:0;
        }
        .btn-back-circle:hover { background:#F3F4F6; }
        .toko-header h1 { font-size:20px; font-weight:700; color:#1E1E1E; margin:0; }

        /* Stepper */
        .stepper { display:flex; align-items:center; margin-bottom:40px; }
        .step-node { display:flex; flex-direction:column; align-items:center; flex-shrink:0; }
        .step-circle { width:44px; height:44px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:16px; }
        .step-circle.active   { background:#34699A; color:#fff; }
        .step-circle.inactive { background:#E5E7EB; border:1px solid #D1D5DB; color:#9CA3AF; }
        .step-text { font-size:12px; margin-top:6px; white-space:nowrap; color:#9CA3AF; }
        .step-text.active { font-weight:600; color:#34699A; }
        .step-connector { flex:1; height:2px; background:#34699A; align-self:flex-start; margin-top:22px; }

        /* Success card */
        .success-card {
            background:#fff; border-radius:14px;
            box-shadow:0 2px 20px rgba(0,0,0,0.07);
            padding:72px 40px; text-align:center;
        }
        .check-circle {
            width:80px; height:80px; border-radius:50%;
            background:#34699A; color:#fff;
            display:flex; align-items:center; justify-content:center;
            font-size:36px; margin:0 auto 28px;
        }
        .success-card h2 { font-size:24px; font-weight:700; color:#1E1E1E; margin:0 0 10px; }
        .success-card p  { font-size:14px; color:#6B7280; margin:0 0 44px; }
        .btn-group { display:flex; gap:16px; justify-content:center; flex-wrap:wrap; }
        .btn-action {
            background:#34699A; color:#fff;
            padding:14px 36px; border-radius:8px;
            font-weight:600; font-size:14px; font-family:inherit;
            text-decoration:none; transition:background .2s;
            display:inline-block;
        }
        .btn-action:hover { background:#2b5a87; }
    </style>
</head>
<body>

    @include('layouts.partials.navbar')

    <main class="toko-wrap">

        {{-- Header --}}
        <div class="toko-header">
            <a href="{{ route('home') }}" class="btn-back-circle" title="Kembali">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M10 13L5 8L10 3" stroke="#374151" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <h1>Selesai</h1>
        </div>

        {{-- Stepper --}}
        <div class="stepper">
            <div class="step-node">
                <div class="step-circle inactive">1</div>
                <span class="step-text">Data Toko</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-node">
                <div class="step-circle inactive">2</div>
                <span class="step-text">Verifikasi</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-node">
                <div class="step-circle active">3</div>
                <span class="step-text active">Selesai</span>
            </div>
        </div>

        {{-- Success Card --}}
        <div class="success-card">
            <div class="check-circle">✓</div>
            <h2>Toko kamu berhasil dibuat!</h2>
            <p>Sekarang kamu bisa mulai menambahkan barang dan mulai sewakan</p>
            <div class="btn-group">
                <a href="{{ route('store.dashboardToko') }}" class="btn-action">Lihat dashboard toko</a>
                <a href="{{ route('home') }}" class="btn-action">Kembali ke beranda</a>
            </div>
        </div>

    </main>

    @include('layouts.partials.footer')

</body>
</html>