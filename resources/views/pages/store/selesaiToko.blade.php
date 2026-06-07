<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Toko - Rentalin</title>
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

        /* Status Card */
        .success-card {
            background:#fff; border-radius:14px;
            box-shadow:0 2px 20px rgba(0,0,0,0.07);
            padding:72px 40px; text-align:center;
        }
        
        /* Modifikasi untuk Pending */
        .pending-circle {
            width:80px; height:80px; border-radius:50%;
            background:#FEF3C7; 
            color:#D97706; 
            display:flex; align-items:center; justify-content:center;
            margin:0 auto 28px;
        }

        /* Modifikasi untuk Rejected */
        .rejected-circle {
            width:80px; height:80px; border-radius:50%;
            background:#FDE8E8; 
            color:#9B1C1C; 
            display:flex; align-items:center; justify-content:center;
            margin:0 auto 28px;
        }

        .success-card h2 { font-size:24px; font-weight:700; color:#1E1E1E; margin:0 0 10px; }
        .success-card p  { font-size:14px; color:#6B7280; margin:0 auto 20px; max-width: 500px; line-height: 1.6; }
        
        .notes-box {
            background-color: #FDF2F2;
            border-left: 4px solid #F8B4B4;
            padding: 16px;
            margin: 0 auto 40px;
            max-width: 500px;
            text-align: left;
            border-radius: 4px;
        }

        .btn-group { display:flex; gap:16px; justify-content:center; flex-wrap:wrap; margin-top: 30px;}
        .btn-action {
            background:#34699A; color:#fff;
            padding:14px 36px; border-radius:8px;
            font-weight:600; font-size:14px; font-family:inherit;
            text-decoration:none; transition:background .2s;
            display:inline-block;
        }
        .btn-action:hover { background:#2b5a87; }
        .btn-action.btn-danger {
            background:#E02424;
        }
        .btn-action.btn-danger:hover { background:#C81E1E; }
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

        {{-- Status Card --}}
        <div class="success-card">
            
            @if(isset($toko) && $toko->status === 'rejected')
                <div class="rejected-circle">
                    {{-- SVG Silang --}}
                    <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h2 style="color: #9B1C1C;">Verifikasi Toko Ditolak</h2>
                <p>Maaf, pengajuan toko Anda tidak memenuhi syarat kami. Silakan periksa alasan penolakan di bawah ini.</p>
                
                @if($toko->notes)
                    <div class="notes-box">
                        <strong style="color: #9B1C1C; display: block; margin-bottom: 4px;">Alasan Admin:</strong>
                        <span style="color: #9B1C1C;">{{ $toko->notes }}</span>
                    </div>
                @endif
                
                <div class="btn-group">
                    <a href="{{ route('home') }}" class="btn-action">Kembali ke Beranda</a>
                    {{-- Ganti route('store.step1Toko') dengan rute Anda untuk edit pendaftaran ulang jika ada --}}
                    <a href="{{ route('store.step1Toko') }}" class="btn-action btn-danger">Ajukan Ulang</a>
                </div>

            @else
                {{-- Tampilan Pending (Default) --}}
                <div class="pending-circle">
                    {{-- SVG Jam / Menunggu --}}
                    <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2>Menunggu Verifikasi Admin</h2>
                <p style="margin-bottom: 44px;">Data pengajuan toko Anda telah kami terima dan saat ini sedang dalam antrean pengecekan. Mohon menunggu hingga proses verifikasi selesai dilakukan oleh tim kami.</p>
                <div class="btn-group">
                    <a href="{{ route('home') }}" class="btn-action">Kembali ke Beranda</a>
                </div>
            @endif

        </div>

    </main>

    @include('layouts.partials.footer')

</body>
</html>