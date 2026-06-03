<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Toko - Rentalin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Nunito+Sans:wght@800&family=Poppins:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        .step-form-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
            padding: 36px 40px;
            max-width: 900px;
            margin: 0 auto;
        }
        .step-input {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 0.95rem;
            color: #374151;
            outline: none;
            box-sizing: border-box;
        }
        .step-input:focus { border-color: #3b5fa0; }
        .step-label { font-weight: 500; color: #374151; margin-bottom: 6px; display:block; }
        .step-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 20px; }
        .step-group { display: flex; flex-direction: column; }
        .error-msg { color: #ef4444; font-size: 0.8rem; margin-top: 4px; }
        /* Stepper */
        .stepper { display:flex; align-items:center; gap:0; margin-bottom:40px; }
        .step-dot { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.95rem; }
        .step-dot.active { background:#3b5fa0; color:#fff; }
        .step-dot.inactive { background:#e5e7eb; color:#9ca3af; }
        .step-line { flex:1; height:2px; background:#d1d5db; }
        .step-line.done { background:#3b5fa0; }
        .step-label-text { font-size:0.75rem; margin-top:6px; text-align:center; }
        .step-item { display:flex; flex-direction:column; align-items:center; }
    </style>
</head>
<body>

    @include('layouts.partials.navbar')

    <main class="page-container" style="padding: 32px 40px; max-width: 960px; margin: 0 auto;">

        <div style="display:flex; align-items:center; gap:16px; margin-bottom:32px;">
            <a href="{{ route('toko.mulai') }}" style="text-decoration:none; color:#374151; font-size:1.2rem;">←</a>
            <h1 style="font-size:1.4rem; font-weight:700; color:#1e1e2e; margin:0;">Informasi Toko</h1>
        </div>

        {{-- Stepper --}}
        <div class="stepper">
            <div class="step-item">
                <div class="step-dot active">1</div>
                <span class="step-label-text" style="color:#3b5fa0; font-weight:600;">Info Toko</span>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-dot inactive">2</div>
                <span class="step-label-text" style="color:#9ca3af;">Verifikasi</span>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-dot inactive">3</div>
                <span class="step-label-text" style="color:#9ca3af;">Selesai</span>
            </div>
        </div>

        {{-- Form --}}
        <div class="step-form-card">

            @if ($errors->any())
                <div style="background:#fee2e2; color:#b91c1c; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:0.9rem;">
                    <ul style="margin:0; padding-left:16px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('toko.step1.simpan') }}" method="POST">
                @csrf

                <div class="step-grid-2">
                    <div class="step-group">
                        <label class="step-label">Nama Toko</label>
                        <input type="text" name="nama_toko" class="step-input"
                               placeholder="Masukkan nama toko"
                               value="{{ old('nama_toko', $data['nama_toko'] ?? '') }}">
                        @error('nama_toko') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="step-group">
                        <label class="step-label">Alamat Toko</label>
                        <input type="text" name="alamat_toko" class="step-input"
                               placeholder="Masukkan alamat toko"
                               value="{{ old('alamat_toko', $data['alamat_toko'] ?? '') }}">
                        @error('alamat_toko') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="step-group" style="margin-bottom:20px;">
                    <label class="step-label">Deskripsi Toko <span style="color:#9ca3af;">(Opsional)</span></label>
                    <textarea name="deskripsi" class="step-input" rows="4"
                              placeholder="Ceritakan sedikit tentang toko kamu...">{{ old('deskripsi', $data['deskripsi'] ?? '') }}</textarea>
                </div>

                <div class="step-grid-2" style="margin-bottom:36px;">
                    <div class="step-group">
                        <label class="step-label">No Telepon</label>
                        <input type="text" name="no_telepon" class="step-input"
                               placeholder="Masukkan no telepon"
                               value="{{ old('no_telepon', $data['no_telepon'] ?? '') }}">
                        @error('no_telepon') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div style="text-align:center;">
                    <button type="submit"
                            style="background:#3b5fa0; color:#fff; padding:14px 60px;
                                   border:none; border-radius:8px; font-size:1rem;
                                   font-weight:600; cursor:pointer;">
                        Lanjutkan
                    </button>
                </div>

            </form>
        </div>

    </main>

    @include('layouts.partials.footer')

</body>
</html>