<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Toko - Rentalin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        .toko-wrap {
            width: 100%;
            max-width: 1289px;
            margin: 0 auto;
            padding: 28px 40px 60px;
            box-sizing: border-box;
        }

        /* Header */
        .toko-header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
        .btn-back-circle {
            width: 36px; height: 36px; border-radius: 50%;
            border: 1.5px solid #D1D5DB; background: #fff;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none; color: #374151;
            transition: background .15s; flex-shrink: 0;
        }
        .btn-back-circle:hover { background: #F3F4F6; }
        .toko-header h1 { font-size: 20px; font-weight: 700; color: #1E1E1E; margin: 0; }

        /* Stepper */
        .stepper { display: flex; align-items: center; margin-bottom: 32px; }
        .step-node { display: flex; flex-direction: column; align-items: center; flex-shrink: 0; }
        .step-circle {
            width: 44px; height: 44px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 16px;
        }
        .step-circle.active   { background: #34699A; color: #fff; }
        .step-circle.inactive { background: #E5E7EB; border: 1px solid #D1D5DB; color: #9CA3AF; }
        .step-text { font-size: 12px; margin-top: 6px; white-space: nowrap; color: #9CA3AF; }
        .step-text.active { font-weight: 600; color: #34699A; }
        .step-connector { flex: 1; height: 2px; background: #D1D5DB; align-self: flex-start; margin-top: 22px; }
        .step-connector.done { background: #34699A; }

        /* Form card */
        .form-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.07);
            padding: 40px 48px;
        }

        /* Error */
        .alert-error { background: #FEF2F2; color: #B91C1C; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-size: 13px; }
        .alert-error ul { margin: 0; padding-left: 16px; }

        /* Grid */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 28px; margin-bottom: 24px; }
        .fg { display: flex; flex-direction: column; gap: 8px; }
        .fg.mb0 { margin-bottom: 0; }
        .fg.mb24 { margin-bottom: 24px; }

        /* Label & input */
        .fg label { font-size: 14px; font-weight: 500; color: #374151; }
        .fg label span { color: #9CA3AF; font-weight: 400; }
        .fi {
            width: 100%; box-sizing: border-box;
            border: 1px solid #D1D5DB; border-radius: 8px;
            padding: 13px 16px; font-size: 14px; color: #374151;
            font-family: inherit; outline: none; background: #fff;
            transition: border-color .2s, box-shadow .2s;
        }
        .fi::placeholder { color: #9CA3AF; }
        .fi:focus { border-color: #34699A; box-shadow: 0 0 0 3px rgba(52,105,154,.1); }
        textarea.fi { resize: vertical; min-height: 110px; }
        .fe { font-size: 12px; color: #EF4444; }

        /* Submit */
        .form-footer { text-align: center; margin-top: 40px; }
        .btn-lanjut {
            background: #34699A; color: #fff;
            font-family: inherit; font-weight: 600; font-size: 15px;
            padding: 14px 64px; border-radius: 8px; border: none;
            cursor: pointer; transition: background .2s;
        }
        .btn-lanjut:hover { background: #2b5a87; }
    </style>
</head>
<body>

    @include('layouts.partials.navbar')

    <main class="toko-wrap">

        {{-- Header --}}
        <div class="toko-header">
            <a href="{{ route('store.bukaToko') }}" class="btn-back-circle" title="Kembali">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M10 13L5 8L10 3" stroke="#374151" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <h1>Informasi Toko</h1>
        </div>

        {{-- Stepper --}}
        <div class="stepper">
            <div class="step-node">
                <div class="step-circle active">1</div>
                <span class="step-text active">Info Toko</span>
            </div>
            <div class="step-connector done"></div>
            <div class="step-node">
                <div class="step-circle inactive">2</div>
                <span class="step-text">Verifikasi</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-node">
                <div class="step-circle inactive">3</div>
                <span class="step-text">Selesai</span>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="form-card">

            @if ($errors->any())
                <div class="alert-error">
                    <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('store.step1Toko.simpan') }}" method="POST">
                @csrf

                <div class="grid-2">
                    <div class="fg">
                        <label>Nama Toko</label>
                        <input type="text" name="nama_toko" class="fi" placeholder="Masukkan nama toko"
                               value="{{ old('nama_toko', $data['nama_toko'] ?? '') }}">
                        @error('nama_toko')<span class="fe">{{ $message }}</span>@enderror
                    </div>
                    <div class="fg">
                        <label>Alamat Toko</label>
                        <input type="text" name="alamat_toko" class="fi" placeholder="Masukkan alamat toko"
                               value="{{ old('alamat_toko', $data['alamat_toko'] ?? '') }}">
                        @error('alamat_toko')<span class="fe">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="fg mb24">
                    <label>Deskripsi Toko <span>(Opsional)</span></label>
                    <textarea name="deskripsi" class="fi" placeholder="Ceritakan sedikit tentang toko kamu...">{{ old('deskripsi', $data['deskripsi'] ?? '') }}</textarea>
                </div>

                <div class="grid-2" style="margin-bottom:0;">
                    <div class="fg">
                        <label>No Telepon</label>
                        <input type="text" name="no_telepon" class="fi" placeholder="Masukkan no telepon"
                               value="{{ old('no_telepon', $data['no_telepon'] ?? '') }}">
                        @error('no_telepon')<span class="fe">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn-lanjut">Lanjutkan</button>
                </div>

            </form>
        </div>

    </main>

    @include('layouts.partials.footer')

</body>
</html>