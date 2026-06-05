<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Berhasil Dibuat - Rentalin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Nunito+Sans:wght@800&family=Poppins:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        .step-dot { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.95rem; }
        .step-dot.active { background:#3b5fa0; color:#fff; }
        .step-dot.inactive { background:#e5e7eb; color:#9ca3af; }
        .step-line { flex:1; height:2px; background:#d1d5db; }
        .step-item { display:flex; flex-direction:column; align-items:center; }
    </style>
</head>
<body>

    @include('layouts.partials.navbar')

    <main class="page-container" style="padding:32px 40px; max-width:960px; margin:0 auto;">

        <div style="display:flex; align-items:center; gap:16px; margin-bottom:32px;">
            <a href="{{ route('home') }}" style="text-decoration:none; color:#374151; font-size:1.2rem;">←</a>
            <h1 style="font-size:1.4rem; font-weight:700; color:#1e1e2e; margin:0;">Selesai</h1>
        </div>

        {{-- Stepper --}}
        <div style="display:flex; align-items:center; gap:0; margin-bottom:40px;">
            <div class="step-item">
                <div class="step-dot inactive">1</div>
                <span style="font-size:0.75rem; margin-top:6px; color:#9ca3af;">Data Toko</span>
            </div>
            <div class="step-line" style="background:#3b5fa0;"></div>
            <div class="step-item">
                <div class="step-dot inactive">2</div>
                <span style="font-size:0.75rem; margin-top:6px; color:#9ca3af;">Verifikasi</span>
            </div>
            <div class="step-line" style="background:#3b5fa0;"></div>
            <div class="step-item">
                <div class="step-dot active">3</div>
                <span style="font-size:0.75rem; margin-top:6px; color:#3b5fa0; font-weight:600;">Selesai</span>
            </div>
        </div>

        <div style="background:#fff; border-radius:12px; box-shadow:0 2px 16px rgba(0,0,0,0.08); padding:60px 40px; text-align:center; max-width:700px; margin:0 auto;">

            <div style="width:72px; height:72px; border-radius:50%; background:#3b5fa0; display:flex; align-items:center; justify-content:center; margin:0 auto 28px; font-size:2rem; color:#fff;">
                ✓
            </div>

            <h2 style="font-size:1.5rem; font-weight:700; color:#1e1e2e; margin-bottom:12px;">
                Toko kamu berhasil dibuat!
            </h2>
            <p style="color:#6b7280; font-size:0.95rem; margin-bottom:40px;">
                Sekarang kamu bisa mulai menambahkan barang dan mulai sewakan
            </p>

            <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
                <a href="{{ route('store') }}"
                   style="background:#3b5fa0; color:#fff; padding:14px 32px; border-radius:8px; font-weight:600; text-decoration:none;">
                    Lihat dashboard toko
                </a>
                <a href="{{ route('home') }}"
                   style="background:#3b5fa0; color:#fff; padding:14px 32px; border-radius:8px; font-weight:600; text-decoration:none;">
                    Kembali ke beranda
                </a>
            </div>

        </div>

    </main>

    @include('layouts.partials.footer')

</body>
</html>